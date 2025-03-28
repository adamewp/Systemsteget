<?php
// Check if config.php exists and include it
if (!file_exists('config.php')) {
    die('Configuration file not found');
}
require_once 'config.php';

// Create database connection
try {
    // Initialize connection
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    // Check connection
    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }
    
    // Set charset to utf8mb4
    if (!$db->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $db->error);
    }
    
    // Set timezone
    $db->query("SET time_zone = '+01:00'");
    
} catch (Exception $e) {
    // Log the error but don't expose details to users
    error_log("Database connection error: " . $e->getMessage());
    die("Could not connect to the database. Please try again later.");
} 