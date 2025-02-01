<?php
require_once __DIR__ . '/db_init.php';

function testFirebaseConnection() {
    try {
        echo "Testing Firebase Connection...\n";
        
        // Test 1: Basic Connection
        $db = getDatabase();
        echo "✅ Successfully connected to Firebase!\n\n";
        
        // Test 2: Write Operation
        echo "Testing Write Operation...\n";
        $testRef = $db->getReference('test');
        $testRef->set([
            'timestamp' => time(),
            'message' => 'Test successful'
        ]);
        echo "✅ Successfully wrote data to Firebase!\n\n";
        
        // Test 3: Read Operation
        echo "Testing Read Operation...\n";
        $testData = $testRef->getValue();
        if ($testData && isset($testData['message'])) {
            echo "✅ Successfully read data from Firebase!\n";
            echo "Retrieved message: " . $testData['message'] . "\n\n";
        }
        
        // Test 4: Delete Test Data
        echo "Cleaning up test data...\n";
        $testRef->remove();
        echo "✅ Successfully cleaned up test data!\n\n";
        
        // Test 5: Test User Operations
        echo "Testing User Operations...\n";
        $testUser = [
            'google_id' => 'test_user_' . time(),
            'name' => 'Test User',
            'email' => 'test@example.com'
        ];
        
        $userId = saveUser($testUser);
        echo "✅ Successfully saved test user!\n";
        
        // Test 6: Test Steps Operations
        echo "Testing Steps Operations...\n";
        $today = date('Y-m-d');
        saveSteps($userId, $today, 10000);
        echo "✅ Successfully saved test steps!\n";
        
        $steps = getSteps($userId);
        if ($steps && isset($steps[$today])) {
            echo "✅ Successfully retrieved steps data!\n";
            echo "Retrieved steps for today: " . $steps[$today]['step_count'] . "\n\n";
        }
        
        // Clean up test user data
        echo "Cleaning up test user data...\n";
        $db->getReference('users/' . $userId)->remove();
        $db->getReference('steps/' . $userId)->remove();
        echo "✅ Successfully cleaned up test user data!\n\n";
        
        echo "All tests completed successfully! 🎉\n";
        echo "Your Firebase setup is working correctly!\n";
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
        echo "Please check your Firebase credentials and configuration.\n";
    }
}

// Run the tests
testFirebaseConnection(); 