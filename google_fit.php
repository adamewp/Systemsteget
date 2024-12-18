<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

class GoogleFitAPI {
    private $client;
    private $fitness_service;
    private $oauth2_service;
    private $pdo;

    public function __construct($access_token) {
        // Initialize Google Client
        $this->client = new Google_Client();
        $this->client->setClientId($GLOBALS['google_client_id']);
        $this->client->setClientSecret($GLOBALS['google_client_secret']);
        
        error_log("Initial access token: " . json_encode($access_token));
        
        // If we received a string instead of an array, convert it
        if (is_string($access_token)) {
            $access_token = json_decode($access_token, true) ?: ['access_token' => $access_token];
        }
        
        $this->client->setAccessToken($access_token);
        
        // Set up token refresh
        if ($this->client->isAccessTokenExpired()) {
            error_log("Token is expired, attempting refresh");
            $refresh_token = $this->client->getRefreshToken();
            if (!$refresh_token && isset($access_token['refresh_token'])) {
                $refresh_token = $access_token['refresh_token'];
                error_log("Using refresh token from session: " . $refresh_token);
            }
            
            if ($refresh_token) {
                error_log("Attempting to refresh token with refresh token: " . $refresh_token);
                try {
                    $new_token = $this->client->fetchAccessTokenWithRefreshToken($refresh_token);
                    error_log("Refresh result: " . json_encode($new_token));
                    
                    if (!isset($new_token['error'])) {
                        // Preserve the refresh token as it might not be returned in the new token
                        if (!isset($new_token['refresh_token']) && $refresh_token) {
                            $new_token['refresh_token'] = $refresh_token;
                        }
                        
                        $_SESSION['access_token'] = $new_token;
                        $this->client->setAccessToken($new_token);
                        error_log("Token refreshed successfully");
                    } else {
                        error_log("Error refreshing token: " . $new_token['error']);
                    }
                } catch (Exception $e) {
                    error_log("Exception while refreshing token: " . $e->getMessage());
                }
            } else {
                error_log("No refresh token available");
            }
        }
        
        // Initialize Services
        $this->fitness_service = new Google_Service_Fitness($this->client);
        $this->oauth2_service = new Google_Service_Oauth2($this->client);
        
        // Initialize database connection
        $this->pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Save or update user information
        $this->saveUserInfo();
    }

    private function saveUserInfo() {
        try {
            // Get user info from Google
            $google_user = $this->oauth2_service->userinfo->get();
            error_log("Got user info from Google: " . $google_user->name . " (ID: " . $google_user->id . ")");
            
            // Prepare the statement
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, google_id)
                VALUES (:name, :email, :google_id)
                ON DUPLICATE KEY UPDATE
                name = :name, email = :email
            ");
            
            // Execute with user data
            $stmt->execute([
                ':name' => $google_user->name,
                ':email' => $google_user->email,
                ':google_id' => $google_user->id
            ]);

            // Store user ID in session for later use
            $_SESSION['user_id'] = $this->pdo->lastInsertId() ?: $this->getUserIdByGoogleId($google_user->id);
            error_log("User ID stored in session: " . $_SESSION['user_id']);
        } catch (Exception $e) {
            error_log("Error saving user info: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
        }
    }

    private function getUserIdByGoogleId($google_id) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE google_id = ?");
        $stmt->execute([$google_id]);
        return $stmt->fetchColumn();
    }

    public function getLeaderboard() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    u.name,
                    COALESCE(s.step_count, 0) as total_steps,
                    CASE 
                        WHEN s.step_count IS NULL THEN NULL
                        ELSE RANK() OVER (ORDER BY s.step_count DESC)
                    END as `rank`
                FROM users u
                LEFT JOIN steps s ON u.id = s.user_id
                    AND s.date = CURDATE()
                ORDER BY total_steps DESC, u.name ASC
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // If no steps recorded yet, still show users with rank 0
            if (empty($results)) {
                $stmt = $this->pdo->prepare("
                    SELECT 
                        name,
                        0 as total_steps,
                        NULL as `rank`
                    FROM users
                    ORDER BY name ASC
                ");
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $results;
        } catch (Exception $e) {
            error_log("Error fetching leaderboard: " . $e->getMessage());
            error_log("Full SQL error: " . print_r($e, true));
            return [];
        }
    }

    public function getDailySteps($startTimeMillis, $endTimeMillis) {
        try {
            // Ensure we have valid timestamps
            if ($startTimeMillis <= 0 || $endTimeMillis <= 0) {
                $startTimeMillis = strtotime('today midnight') * 1000;
                $endTimeMillis = time() * 1000;
            }
            
            // Try to refresh token if expired
            if ($this->client->isAccessTokenExpired()) {
                if ($this->client->getRefreshToken()) {
                    $new_token = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    if (!isset($new_token['error'])) {
                        $_SESSION['access_token'] = $new_token;
                        $this->client->setAccessToken($new_token);
                    } else {
                        error_log("Failed to refresh token: " . $new_token['error']);
                        return false;
                    }
                } else {
                    error_log("No refresh token available");
                    return false;
                }
            }
            
            error_log("Fetching steps for today: " . date('Y-m-d', $startTimeMillis/1000));
            error_log("Time range: " . date('Y-m-d H:i:s', $startTimeMillis/1000) . " to " . date('Y-m-d H:i:s', $endTimeMillis/1000));
            
            $datasource = "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps";
            
            error_log("Creating Google Fit request...");
            $request = new Google_Service_Fitness_AggregateRequest([
                'aggregateBy' => [
                    [
                        'dataTypeName' => 'com.google.step_count.delta',
                        'dataSourceId' => $datasource
                    ]
                ],
                'bucketByTime' => ['durationMillis' => 86400000], // 1 day in milliseconds
                'startTimeMillis' => $startTimeMillis,
                'endTimeMillis' => $endTimeMillis
            ]);
            
            // Check if token is expired
            if ($this->client->isAccessTokenExpired()) {
                error_log("Access token has expired");
                return false;
            }
            
            error_log("Calling Google Fit API...");
            $dataset = $this->fitness_service->users_dataset->aggregate('me', $request);
            error_log("Received response from Google Fit API");
            
            if (!isset($dataset->bucket)) {
                error_log("No buckets found in response");
                error_log("Response data: " . print_r($dataset, true));
                return false;
            }
            
            error_log("Found " . count($dataset->bucket) . " buckets in response");
            
            if (isset($dataset->bucket) && count($dataset->bucket) > 0) {
                foreach ($dataset->bucket as $bucket) {
                    error_log("Processing bucket for time: " . date('Y-m-d H:i:s', $bucket->startTimeMillis/1000));
                    if (!isset($bucket->dataset[0])) {
                        error_log("No dataset found in bucket");
                        continue;
                    }
                    if (!isset($bucket->dataset[0]->point[0])) {
                        error_log("No points found in dataset");
                        continue;
                    }
                    
                    $steps = $bucket->dataset[0]->point[0]->value[0]->intVal;
                    $date = date('Y-m-d', $bucket->startTimeMillis / 1000);
                    error_log("Found {$steps} steps for today ({$date})");
                    
                    if (!isset($_SESSION['user_id'])) {
                        error_log("Error: user_id not found in session");
                        return false;
                    }
                    
                    // Update steps in database with timestamp
                    $stmt = $this->pdo->prepare("
                        INSERT INTO steps (user_id, step_count, date)
                        VALUES (:user_id, :steps, :date)
                        ON DUPLICATE KEY UPDATE 
                            step_count = :steps
                    ");
                    
                    error_log("Saving steps to database for user_id: " . $_SESSION['user_id']);
                    $stmt->execute([
                        ':user_id' => $_SESSION['user_id'],
                        ':steps' => $steps,
                        ':date' => $date
                    ]);
                    error_log("Successfully saved today's steps to database");
                }
                return true;
            } else {
                error_log("No data found in Google Fit response for today");
                error_log("Response data: " . print_r($dataset, true));
            }
            return false;
        } catch (Exception $e) {
            error_log("Error fetching steps: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
} 