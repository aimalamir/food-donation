<?php
session_start();
include 'connection.php';

if (isset($_POST['feedback'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];
    
    // Sanitize inputs to prevent SQL injection
    $sanitized_email = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);
    
    // Insert feedback into the database
    $query = "INSERT INTO user_feedback (name, email, message) VALUES ('$sanitized_name', '$sanitized_email', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);
    
    if ($query_run) {
        // Feedback inserted successfully
        header("Location: contact.html");
        exit(); // Stop further execution
    } else {
        // Error occurred while inserting feedback
        echo '<script type="text/javascript">alert("Error: Data not saved")</script>';
    }
}
?>
