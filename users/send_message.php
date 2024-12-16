<?php
session_start();
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propertyId = $_POST['property_id'];
    $message = $_POST['message'];
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in the session

    // Save message to the database (assuming you have a messages table)
    $query = "INSERT INTO owner_messages (property_id, user_id, message, created_at) VALUES ('$propertyId', '$userId', '$message', NOW())";
    if (mysqli_query($conn, $query)) {
        echo 'Message sent.';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>