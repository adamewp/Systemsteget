<?php
// Database configuration
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_NAME = getenv('DB_NAME') ?: 'step_challenge';
$DB_USER = getenv('DB_USER') ?: 'systemsteget';
$DB_PASS = getenv('DB_PASS') ?: 'xK9#mP2$vL5nQ8@jR3hT7*wC4pY6&bN9';

// Google OAuth configuration
$google_client_id = getenv('GOOGLE_CLIENT_ID') ?: '1296625850-dsj4trr442gnu9ug19ehicllckbj21r2.apps.googleusercontent.com';
$google_client_secret = getenv('GOOGLE_CLIENT_SECRET') ?: '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';

// Application settings
$APP_URL = getenv('APP_URL') ?: 'http://localhost';
$APP_NAME = getenv('APP_NAME') ?: 'Uppsala Systemvetare Step Challenge';

// Error reporting
if (getenv('APP_ENV') !== 'production') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
 