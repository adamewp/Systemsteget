<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'db_connection.php';

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php_errors.log');

// Get JSON data from the request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Log the received data for debugging
error_log("Raw JSON received: " . $json);
error_log("Decoded data: " . print_r($data, true));

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Validate required fields: "firstName", "lastName", "steps", and "email"
if (!isset($data['firstName']) || !isset($data['lastName']) || !isset($data['steps']) || !isset($data['email'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields: firstName, lastName, steps or email']);
    exit;
}

// Trim and sanitize name
$name = trim($data['firstName'] . ' ' . $data['lastName']);
if (empty($name)) {
    http_response_code(400);
    echo json_encode(['error' => 'Name cannot be empty']);
    exit;
}

// Trim and sanitize email
$email = trim($data['email']);
if (empty($email)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email cannot be empty']);
    exit;
}

// Get the total steps count
$steps = (int) $data['steps'];

// Validate that steps is a positive integer
if ($steps < 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid steps count']);
    exit;
}

// Try to process the request
try {
    // Remove the lines that delete existing users and steps data
    // $db->query("DELETE FROM users");
    // $db->query("DELETE FROM steps");

    // Prepare the SQL statement to check if the user already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    if (!$stmt->execute()) {
        throw new Exception("User select failed: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // User exists, update the steps
        $userId = $user['id'];
        $stmt = $db->prepare("UPDATE steps SET step_count = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $steps, $userId);
        if (!$stmt->execute()) {
            throw new Exception("Steps update failed: " . $stmt->error);
        }
    } else {
        // User does not exist, insert new user and steps
        $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        if (!$stmt->execute()) {
            throw new Exception("User insert failed: " . $stmt->error);
        }

        // Fetch the user's ID
        $stmt = $db->prepare("SELECT id FROM users WHERE name = ?");
        $stmt->bind_param("s", $name);
        if (!$stmt->execute()) {
            throw new Exception("User select failed: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if (!$user) {
            throw new Exception("User not found after insert");
        }
        $userId = $user['id'];

        // Insert the total steps into the 'steps' table
        $stmt = $db->prepare("INSERT INTO steps (user_id, step_count) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $steps);
        if (!$stmt->execute()) {
            throw new Exception("Steps insert failed: " . $stmt->error);
        }
    }

    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Name, steps and email updated successfully',
        'data' => [
            'name' => $name,
            'steps' => $steps,
            'email' => $email
        ]
    ]);

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => $e->getMessage()
    ]);
}
?>
