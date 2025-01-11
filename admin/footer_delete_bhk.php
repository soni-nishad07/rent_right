<?php
session_start();
include('../connection.php'); // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $query = "DELETE FROM bhk_searches WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'BHK deleted successfully!';
    } else {
        $_SESSION['message'] = 'Error deleting BHK: ' . mysqli_error($conn);
    }

    header('Location: footer.php'); // Redirect to the page where the form is
    exit;
}
?>
