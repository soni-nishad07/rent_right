<?php
session_start();
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $property_id = $_POST['property_id'] ?? '';

    if (!empty($property_id)) {
        // Replace with actual user ID logic
        $user_id = $_SESSION['user_id'] ?? 1;

        // Prevent SQL injection
        $property_id = mysqli_real_escape_string($conn, $property_id);

        // Check if the property is already saved
        $query = "SELECT * FROM save_items WHERE user_id = '$user_id' AND property_id = '$property_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo 'already_saved';
        } else {
            // Insert the saved property
            $insert_query = "INSERT INTO save_items (user_id, property_id) VALUES ('$user_id', '$property_id')";
            if (mysqli_query($conn, $insert_query)) {
                echo 'saved';
            } else {
                echo 'error';
            }
        }
    } else {
        echo 'invalid';
    }
} else {
    echo 'invalid_request';
}
?>
