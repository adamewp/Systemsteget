<?php
session_start();

// Clear the session
session_unset();
session_destroy();

// Redirect back to the leaderboard
header('Location: leaderboard.php');
exit;