<?php
// Load environment variables if .env file exists
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

// Database configuration
$db_host = getenv('DB_HOST') ?: 'mysql13.loopia.se';  
$db_name = getenv('DB_NAME') ?: 'uppsalasystemvetare_se_db_7';      
$db_user = getenv('DB_USER') ?: 'steget25@u374391';      
$db_pass = getenv('DB_PASS') ?: '3FY80xsB57Ol';                              

// Google OAuth configuration
$google_client_id = getenv('GOOGLE_CLIENT_ID') ?: '1296625850-dsj4trr442gnu9ug19ehicllckbj21r2.apps.googleusercontent.com';
$google_client_secret = getenv('GOOGLE_CLIENT_SECRET') ?: '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';

// Application settings
$APP_URL = getenv('APP_URL') ?: 'https://steg.uppsalasystsemvetare.se';
$APP_NAME = getenv('APP_NAME') ?: 'Uppsala Systemvetare Step Challenge';

// Error reporting
if (getenv('APP_ENV') !== 'production') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');
 