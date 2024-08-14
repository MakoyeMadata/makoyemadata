<?php
// Connect to database
include "db_conn.php";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    
    try {
        // Insert subscriber into database
        $stmt = $conn->prepare("INSERT INTO subscribers (email, timestamp) VALUES (?, NOW())");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        echo "Subscription successful!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
