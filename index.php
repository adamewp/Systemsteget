<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systemsteget - Uppsala Systemvetare</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

session_start();

// Initialize any required configurations
if (getenv('APP_ENV') !== 'production') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Redirect to the leaderboard page
header('Location: leaderboard.php');
exit();
?> 