<?php
require_once __DIR__ . '/config/firebase_config.php';

function getDatabase() {
    static $database = null;
    
    if ($database === null) {
        $database = getFirebaseInstance();
    }
    
    return $database;
}

// Helper functions for common database operations
function saveUser($userData) {
    $db = getDatabase();
    $usersRef = $db->getReference('users');
    
    // Use Google ID as the key for the user
    $userRef = $usersRef->getChild($userData['google_id']);
    $userRef->set([
        'name' => $userData['name'],
        'email' => $userData['email'],
        'created_at' => time()
    ]);
    
    return $userData['google_id'];
}

function saveSteps($userId, $date, $stepCount) {
    $db = getDatabase();
    $stepsRef = $db->getReference('steps');
    
    // Format: steps/userId/YYYY-MM-DD
    $dateKey = date('Y-m-d', strtotime($date));
    $stepRef = $stepsRef->getChild($userId)->getChild($dateKey);
    
    $stepRef->set([
        'step_count' => $stepCount,
        'updated_at' => time()
    ]);
    
    return $stepRef->getValue();
}

function getSteps($userId, $startDate = null, $endDate = null) {
    $db = getDatabase();
    $stepsRef = $db->getReference('steps')->getChild($userId);
    
    if ($startDate && $endDate) {
        // Firebase Realtime Database allows filtering by key
        return $stepsRef
            ->orderByKey()
            ->startAt($startDate)
            ->endAt($endDate)
            ->getValue();
    }
    
    return $stepsRef->getValue();
}