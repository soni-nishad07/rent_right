<?php
session_start();
include('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the category ID from the POST data
    $id = $_POST['id'];

    // Escape the ID to prevent SQL injection
    $id = $conn->real_escape_string($id);

    // Delete category query
    $query = "DELETE FROM category WHERE id = '$id'";

    if ($conn->query($query)) {
        header('Location: category_list.php'); // Redirect to category list after success
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
