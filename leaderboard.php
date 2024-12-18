<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systemsteget - Uppsala Systemvetare</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <?php
    require_once 'vendor/autoload.php';
    require_once 'config.php';

    session_start();

    // Initialize Google Client
    $client = new Google_Client();
    $client->setClientId($google_client_id);
    $client->setClientSecret($google_client_secret);
    $client->setRedirectUri('http://localhost:8000/leaderboard.php');
    $client->addScope('https://www.googleapis.com/auth/fitness.activity.read');
    $client->addScope('profile');
    $client->addScope('email');
    $client->setAccessType('offline');
    $client->setPrompt('consent');
    $client->setIncludeGrantedScopes(true);

    // Handle Google OAuth login
    if (isset($_GET['code'])) {
        try {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            error_log("Received token from Google: " . json_encode($token));
            
            if (!isset($token['error'])) {
                // Make sure we store the refresh token
                if (isset($token['refresh_token'])) {
                    error_log("Received refresh token: " . $token['refresh_token']);
                } else {
                    error_log("No refresh token received from Google");
                }
                
                $_SESSION['access_token'] = $token;
                header('Location: leaderboard.php');
                exit;
            } else {
                error_log("Error in token response: " . $token['error']);
            }
        } catch (Exception $e) {
            error_log("Exception during token fetch: " . $e->getMessage());
        }
    }

    // Check if user is logged in and has valid token data
    $isLoggedIn = isset($_SESSION['access_token']) && 
                  is_array($_SESSION['access_token']) && 
                  isset($_SESSION['access_token']['access_token']);
    ?>
</head>
<body>
    <header>
        <div class="nav-container">
            <img src="US_logo_other.png" alt="Uppsala Systemvetare Logo" class="logo">
            <button class="menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav>
                <ul>
                    <li><a href="leaderboard.php">Topplista</a></li>
                    <li><a href="rules.php">Regler</a></li>
                    <li><a href="contact.php">Kontakt</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="logout.php">Logga ut</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Systemsteget</h1>
        
        <?php if (!$isLoggedIn): ?>
            <div class="auth-section">
                <h2>Delta i stegutmaningen</h2>
                <p>Anslut med ditt Google-konto för att delta i stegutmaningen!</p>
                <a href="<?php echo $client->createAuthUrl(); ?>" class="google-login-btn">
                    Logga in med Google
                </a>
            </div>
        <?php else: ?>
            <div class="leaderboard-container">
                <div class="leaderboard-header">
                    <h2>Aktuell topplista</h2>
                    <p>Dagens steg (<?php echo date('Y-m-d'); ?>)</p>
                    <p>Senast uppdaterad: <span id="last-update"><?php echo date('Y-m-d H:i:s'); ?></span></p>
                    <button id="manual-refresh" class="refresh-btn">Uppdatera nu</button>
                </div>
                <div id="leaderboard-content">
                    <table class="leaderboard-table">
                        <thead>
                            <tr>
                                <th>Plats</th>
                                <th>Namn</th>
                                <th>Antal steg idag</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once 'google_fit.php';
                            $googleFit = new GoogleFitAPI($_SESSION['access_token']);
                            
                            if (isset($_SESSION['user_id'])) {
                                $startTimeMillis = strtotime('today midnight') * 1000;
                                $endTimeMillis = time() * 1000;
                                $googleFit->getDailySteps($startTimeMillis, $endTimeMillis);
                                $_SESSION['last_fetch'] = time();
                            }
                            
                            $leaderboardData = $googleFit->getLeaderboard();
                            
                            if (empty($leaderboardData)) {
                                echo "<tr><td colspan='3' class='no-data'>Inga deltagare än. Bli först att gå med!</td></tr>";
                            } else {
                                foreach ($leaderboardData as $entry) {
                                    echo "<tr>";
                                    echo "<td>" . ($entry['rank'] ?? '-') . "</td>";
                                    echo "<td>" . htmlspecialchars($entry['name']) . "</td>";
                                    echo "<td>" . number_format($entry['total_steps']) . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
            // Mobile menu toggle
            const menuToggle = document.querySelector('.menu-toggle');
            const nav = document.querySelector('nav');
            
            menuToggle.addEventListener('click', () => {
                menuToggle.classList.toggle('active');
                nav.classList.toggle('active');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!nav.contains(e.target) && !menuToggle.contains(e.target) && nav.classList.contains('active')) {
                    menuToggle.classList.remove('active');
                    nav.classList.remove('active');
                }
            });

            // Function to update the leaderboard
            function updateLeaderboard() {
                fetch('update_leaderboard.php')
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 401) {
                                // Only redirect if we get an actual auth error message
                                return response.text().then(text => {
                                    if (text === 'Token expired' || text === 'Unauthorized') {
                                        window.location.href = 'logout.php';
                                        throw new Error('Session expired. Please log in again.');
                                    }
                                    return text;
                                });
                            }
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(html => {
                        // Only update if we got valid HTML
                        if (html.includes('leaderboard-table')) {
                            document.getElementById('leaderboard-content').innerHTML = html;
                            document.getElementById('last-update').textContent = new Date().toLocaleString('sv-SE');
                        } else {
                            console.error('Invalid response:', html);
                            throw new Error('Invalid response from server');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating leaderboard:', error);
                        if (error.message === 'Session expired. Please log in again.') {
                            // Error already handled
                            return;
                        }
                        // Show error message to user
                        document.getElementById('leaderboard-content').innerHTML = 
                            '<div class="error-message">Det gick inte att uppdatera topplistan. Försök igen senare.</div>';
                    });
            }

            // Manual refresh button
            document.getElementById('manual-refresh').addEventListener('click', function() {
                this.disabled = true;
                updateLeaderboard();
                setTimeout(() => this.disabled = false, 5000); // Prevent spam clicking
            });
            </script>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Uppsala Systemvetare. Alla rättigheter förbehållna.</p>
    </footer>
</body>
</html> 