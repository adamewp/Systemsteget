<?php
// Load environment variables
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (preg_match('/^([^#=]+?)\s*=\s*(.*)$/', $line, $matches)) {
            $key = trim($matches[1]);
            $value = trim($matches[2], "'\"");
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Helper function to get env variables safely
function env($key, $default = null) {
    return getenv($key) ?: ($_ENV[$key] ?? $default);
}

// Site configuration
define('SITE_URL', env('SITE_URL', 'http://localhost'));
define('SITE_NAME', env('SITE_NAME', 'Uppsala Systemvetare Step Challenge'));

// Firebase configuration
define('FIREBASE_PROJECT_ID', env('FIREBASE_PROJECT_ID', ''));
define('FIREBASE_DATABASE_URL', env('FIREBASE_DATABASE_URL', ''));
define('FIREBASE_STORAGE_BUCKET', env('FIREBASE_STORAGE_BUCKET', ''));

// Google OAuth configuration
$google_client_id = env('GOOGLE_CLIENT_ID', '');
$google_client_secret = env('GOOGLE_CLIENT_SECRET', '');

// Application settings
define('APP_URL', env('APP_URL', 'http://localhost'));
define('APP_NAME', env('APP_NAME', 'Uppsala Systemvetare Step Challenge'));
define('APP_ENV', env('APP_ENV', 'development'));

// Error reporting
$error_reporting = env('ERROR_REPORTING', 'E_ALL & ~E_DEPRECATED & ~E_STRICT');
if (defined($error_reporting)) {
    error_reporting(constant($error_reporting));
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

ini_set('display_errors', env('DISPLAY_ERRORS', '0') === '1' ? '1' : '0');

// Time zone setting
date_default_timezone_set('UTC');