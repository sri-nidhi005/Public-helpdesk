<?php
session_start();
require_once 'db_connection.php';

// Create directory for file uploads if it doesn't exist
$upload_dir = "uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $grievance_text = isset($_POST['grievance_text']) ? $_POST['grievance_text'] : '';
    
    // Initialize file path variable
    $file_path = NULL;
    
    // Handle file upload if present
    if(isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] == 0) {
        $allowed_types = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx');
        $file_ext = strtolower(pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION));
        
        // Check if file type is allowed
        if(in_array($file_ext, $allowed_types)) {
            // Create unique filename
            $new_filename = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_filename;
            
            // Move uploaded file
            if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $upload_path)) {
                $file_path = $upload_path;
            }
        }
    }
    
    // Insert grievance into database
    $sql = "INSERT INTO grievances (name, email, grievance_text, file_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $grievance_text, $file_path);
    
    if ($stmt->execute()) {
        echo "<script>alert('Thank you! Your grievance has been submitted successfully.');</script>";
        echo "<script>window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Error submitting grievance: " . $conn->error . "');</script>";
        echo "<script>window.history.back();</script>";
    }
    
    $stmt->close();
    $conn->close();
    exit;
}
?>