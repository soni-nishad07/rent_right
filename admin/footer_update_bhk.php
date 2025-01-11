<?php
session_start();
include('../connection.php'); // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $query = "UPDATE bhk_searches SET name='$name' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'BHK updated successfully!';
    } else {
        $_SESSION['message'] = 'Error updating BHK: ' . mysqli_error($conn);
    }

    header('Location: footer.php'); // Redirect to the page where the form is
    exit;
}
?>
