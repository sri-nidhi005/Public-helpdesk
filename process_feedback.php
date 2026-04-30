<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the rating and feedback text
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $feedback_text = isset($_POST['feedback']) ? $_POST['feedback'] : '';
    
    // Validate rating
    if ($rating < 1 || $rating > 5) {
        echo "<script>alert('Please select a rating between 1 and 5 stars');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }
    
    // Insert feedback into database
    $sql = "INSERT INTO feedback (rating, feedback) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $rating, $feedback_text);
    
    if ($stmt->execute()) {
        echo "<script>alert('Thank you for your feedback!');</script>";
        echo "<script>window.location.href = 'index.html';</script>"; // Redirect to homepage
    } else {
        echo "<script>alert('Error submitting feedback: " . $conn->error . "');</script>";
        echo "<script>window.history.back();</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>