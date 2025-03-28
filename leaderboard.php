<?php
session_start();
require_once 'config.php';
require_once 'db_connection.php';

// Basic error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Updated query without the date filter
    $query = "
        SELECT u.name, SUM(s.step_count) AS total_steps
        FROM users u
        JOIN steps s ON u.id = s.user_id
        GROUP BY u.id
        ORDER BY total_steps DESC";
        
    $stmt = $db->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $db->error);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $leaderboardData = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systemsteget - Topplista</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="nav-container">
            <img src="/US_logo_other.png" alt="Logo" class="logo">
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
                    <li><a href="privacy.php">Integritetspolicy</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Topplista</h1>
        
        <div class="leaderboard-container">
            <?php if (empty($leaderboardData)): ?>
                <p class="no-data">Inga deltagare än.</p>
            <?php else: ?>
                <div class="leaderboard-table">
                    <?php foreach ($leaderboardData as $index => $user): ?>
                        <div class="leaderboard-item" style="padding: 15px; color: var(--text-color);">
                            <?php echo ($index + 1) . ". " . htmlspecialchars($user['name']); ?>: 
                            <?php echo str_replace(' ', '', number_format($user['total_steps'])); ?> steg
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <p class="server-time">* Totalt antal steg under de senaste 7 dagarna.</p>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Uppsala Systemvetare. Alla rättigheter förbehållna.</p>
    </footer>

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
    </script>
</body>
</html>
