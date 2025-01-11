<?php
// update_service.php
include('../connection.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $service_description = mysqli_real_escape_string($conn, $_POST['service_description']);

    // $query = "UPDATE services SET service_name='$service_name'";


    $query = "UPDATE services SET service_name='$service_name', service_description='$service_description' ";

    // $query = "UPDATE services SET service_name='$service_name', service_description='$service_description' WHERE id='$service_id'";


    // Handle file upload
    if (isset($_FILES['service_img']) && $_FILES['service_img']['error'] == 0) {
        $file_tmp = $_FILES['service_img']['tmp_name'];
        $file_name = $_FILES['service_img']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_new_name = uniqid() . '.' . $file_ext;
        $upload_path = '../uploads/services/' . $file_new_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $query .= ", service_img='$file_new_name'";
        } else {
            echo "Failed to upload file.";
            exit;
        }
    }

    $query .= " WHERE id='$service_id'";

    if (mysqli_query($conn, $query)) {
        header('Location: service'); // Redirect to the service page
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
