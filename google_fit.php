<?php
require_once 'vendor/autoload.php';
require_once 'config/firebase_config.php';

class GoogleFitAPI {
    private $client;
    private $fitness_service;
    private $oauth2_service;
    private $db; // Firebase database instance

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
        
        // Initialize Firebase Database
        $this->db = getFirebaseInstance(); // Get the Firebase database instance
        
        // Save or update user information
        $this->saveUserInfo();
    }

    private function saveUserInfo() {
        try {
            // Get user info from Google
            $google_user = $this->oauth2_service->userinfo->get();
            error_log("Got user info from Google: " . $google_user->name . " (ID: " . $google_user->id . ")");
            
            // Save user information to Firebase
            $this->saveUserInfoToFirebase($google_user->id, [
                'name' => $google_user->name,
                'email' => $google_user->email,
                'google_id' => $google_user->id
            ]);

            // Store user ID and name in session for later use
            $_SESSION['user_id'] = $google_user->id; // Store the Google ID directly
            $_SESSION['user_name'] = $google_user->name; // Store the user's name without encoding
            error_log("User ID stored in session: " . $_SESSION['user_id']);
        } catch (Exception $e) {
            error_log("Error saving user info: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
        }
    }

    private function saveUserInfoToFirebase($userId, $userInfo) {
        // Reference to the users node in Firebase
        $userRef = $this->db->getReference('users/' . $userId);
        
        // Set user information
        $userRef->set($userInfo);
    }

    public function getLeaderboard() {
        // Reference to the leaderboard node in Firebase
        $leaderboardRef = $this->db->getReference('leaderboard');

        // Get the leaderboard data
        $leaderboardData = $leaderboardRef->getValue();

        // If no data, return an empty array
        if ($leaderboardData === null) {
            return [];
        }

        // Sort leaderboard data by total steps
        usort($leaderboardData, function($a, $b) {
            return $b['total_steps'] <=> $a['total_steps'];
        });

        // Assign ranks
        foreach ($leaderboardData as $index => &$entry) {
            $entry['rank'] = $index + 1; // Rank starts from 1
        }

        return $leaderboardData;
    }

    public function getDailySteps($startTimeMillis, $endTimeMillis) {
        try {
            // Ensure we have valid timestamps
            if ($startTimeMillis <= 0 || $endTimeMillis <= 0) {
                $startTimeMillis = strtotime('today midnight') * 1000;
                $endTimeMillis = time() * 1000;
            }

            // Check if token is expired and refresh if necessary
            if ($this->client->isAccessTokenExpired()) {
                $this->refreshAccessToken(); // Call the refresh logic
            }

            // Fetch steps from Google Fit
            $datasource = "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps";
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

            $dataset = $this->fitness_service->users_dataset->aggregate('me', $request);

            // Process the response and save steps to Firebase
            if (isset($dataset->bucket) && count($dataset->bucket) > 0) {
                foreach ($dataset->bucket as $bucket) {
                    if (isset($bucket->dataset[0]->point[0]->value[0]->intVal)) {
                        $steps = $bucket->dataset[0]->point[0]->value[0]->intVal;
                        $date = date('Y-m-d', $bucket->startTimeMillis / 1000);
                        $this->saveStepsToFirebase($_SESSION['user_id'], $date, $steps);
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("Error fetching steps: " . $e->getMessage());
            return false;
        }
    }

    private function saveStepsToFirebase($userId, $date, $steps) {
        $stepsRef = $this->db->getReference('steps/' . $userId . '/' . $date);
        $stepsRef->set([
            'step_count' => $steps,
            'updated_at' => time()
        ]);
    }

    private function refreshAccessToken() {
        // Logic to refresh the access token
        $refresh_token = $this->client->getRefreshToken();
        if ($refresh_token) {
            $new_token = $this->client->fetchAccessTokenWithRefreshToken($refresh_token);
            if (!isset($new_token['error'])) {
                $_SESSION['access_token'] = $new_token;
                $this->client->setAccessToken($new_token);
                error_log("Token refreshed successfully");
            } else {
                error_log("Error refreshing token: " . $new_token['error']);
            }
        } else {
            error_log("No refresh token available");
        }
    }

    public function getDatabase() {
        return $this->db;
    }
} 