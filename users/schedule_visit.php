

<?php
session_start();
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propertyId = $_POST['property_id'];
    $visitDate = $_POST['visit_date'];
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in the session

    // Save visit request to the database (assuming you have a visits table)
    $query = "INSERT INTO scheduled_visits (property_id, user_id, visit_date, created_at) VALUES ('$propertyId', '$userId', '$visitDate', NOW())";
    if (mysqli_query($conn, $query)) {
        echo 'Visit scheduled.';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>
