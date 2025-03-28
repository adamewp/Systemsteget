<?php
require_once 'config.php';
require_once 'db_connection.php';

function getLeaderboardData() {
    global $db;
    $today = date('Y-m-d');
    
    $query = "
        SELECT u.name, COALESCE(s.step_count, 0) as steps 
        FROM users u 
        LEFT JOIN steps s ON u.id = s.user_id AND s.date = ?
        ORDER BY steps DESC";
        
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$leaderboardData = getLeaderboardData();
?>

<div class="leaderboard">
    <?php if (empty($leaderboardData)): ?>
        <p class="no-data">Inga deltagare än. Bli först att gå med!</p>
    <?php else: ?>
        <?php foreach ($leaderboardData as $user): ?>
        <div class="leaderboard-item">
            <span class="user-name"><?php echo htmlspecialchars($user['name']); ?></span>
            <span class="steps"><?php echo number_format($user['steps']); ?> steg</span>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div> 