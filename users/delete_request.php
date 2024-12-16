<?php
include('../connection.php');
include('session_check.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enquiry_id'])) {
    $enquiry_id = mysqli_real_escape_string($conn, $_POST['enquiry_id']);
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM enquiries WHERE id = '$enquiry_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $query)) {
        echo "Enquiry deleted successfully.";
    } else {
        echo "Error deleting enquiry: " . mysqli_error($conn);
    }
}

header('Location: enquiries.php');
?>
