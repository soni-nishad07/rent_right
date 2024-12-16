<?php
include('../connection.php');
include('session_check.php');

$response = array();

if (isset($_POST['property_id'])) {
    $user_id = $_SESSION['user_id'];
    $property_id = $_POST['property_id'];
    $message = "User ID: $user_id has sent an enquiry for Property ID: $property_id.";

    $query = "INSERT INTO enquiries (user_id, property_id, message) VALUES ('$user_id', '$property_id', '$message')";
    if (mysqli_query($conn, $query)) {
        $response['message'] = 'Enquiry sent successfully!';
    } else {
        $response['message'] = 'Failed to send enquiry.';
    }
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>