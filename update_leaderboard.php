<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'google_fit.php';

// Check if user is logged in
if (!isset($_SESSION['access_token']) || !$_SESSION['access_token']) {
    http_response_code(401);
    exit('Unauthorized');
}

// Set timezone to ensure consistent date handling
date_default_timezone_set('Europe/Stockholm');

try {
    $googleFit = new GoogleFitAPI($_SESSION['access_token']);

    if (isset($_SESSION['user_id'])) {
        // Force a fresh fetch from Google Fit
        $startTimeMillis = strtotime('today midnight') * 1000;
        $endTimeMillis = time() * 1000;
        
        $success = $googleFit->getDailySteps($startTimeMillis, $endTimeMillis);
        if (!$success) {
            // Token refresh failed or other error occurred
            http_response_code(401);
            exit('Token expired');
        }
        $_SESSION['last_fetch'] = time();
    }

    $leaderboardData = $googleFit->getLeaderboard();
} catch (Exception $e) {
    error_log("Error in update_leaderboard.php: " . $e->getMessage());
    http_response_code(500);
    exit('Error updating leaderboard');
}
?>

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