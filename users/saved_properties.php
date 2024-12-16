<?php
include('../connection.php');
include('session_check.php');

$response = array();

if (isset($_POST['property_id']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $property_id = intval($_POST['property_id']); // Ensure the property ID is an integer

    // Check if the property is already saved
    $check_query = "SELECT * FROM saved_properties WHERE user_id = '$user_id' AND property_id = '$property_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $response['message'] = 'Property is already saved!';
    } else {
        // Save the property
        $insert_query = "INSERT INTO saved_properties (user_id, property_id) VALUES ('$user_id', '$property_id')";
        if (mysqli_query($conn, $insert_query)) {
            $response['message'] = 'Property saved successfully!';
        } else {
            $response['message'] = 'Failed to save property.';
        }
    }

    echo json_encode($response);
    exit();
} else {
    $response['message'] = 'Invalid request. Property ID or user session is missing.';
    echo json_encode($response);
    exit();
}
?>
