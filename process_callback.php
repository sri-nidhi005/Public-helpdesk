<?php
session_start();
require_once 'db_connection.php';

// First make sure the callbacks table exists
$create_table_sql = "CREATE TABLE IF NOT EXISTS callbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(20) NOT NULL,
    submission_time DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($create_table_sql)) {
    echo json_encode(['success' => false, 'message' => 'Error creating callbacks table: ' . $conn->error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the phone number
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    
    // Validate phone number (basic validation)
    if (empty($phone_number)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid phone number']);
        exit;
    }
    
    // Insert callback request into database
    $sql = "INSERT INTO callbacks (phone_number) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone_number);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Thank you! We\'ll call you back shortly.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error submitting callback request: ' . $conn->error]);
    }
    
    $stmt->close();
    $conn->close();
    exit;
}
?>