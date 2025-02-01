<?php
require __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// Firebase configuration
define('FIREBASE_CREDENTIALS', __DIR__ . '/firebase-credentials.json');
define('FIREBASE_DATABASE_URL', 'https://systemsteget-2025-default-rtdb.europe-west1.firebasedatabase.app');
define('FIREBASE_PROJECT_ID', 'systemsteget-2025');
define('FIREBASE_STORAGE_BUCKET', 'systemsteget-2025.firebasestorage.app');

function getFirebaseInstance() {
    try {
        $factory = (new Factory)
            ->withServiceAccount(FIREBASE_CREDENTIALS)
            ->withDatabaseUri(FIREBASE_DATABASE_URL);
        
        return $factory->createDatabase();
    } catch (Exception $e) {
        error_log('Firebase initialization error: ' . $e->getMessage());
        throw new Exception('Failed to initialize Firebase');
    }
} 