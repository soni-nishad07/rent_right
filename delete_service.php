

<?php
// delete_service.php
include('../connection.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    
    // Optionally delete the image file if it exists
    $query = "SELECT service_img FROM services WHERE id='$service_id'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $file_path = 'uploads/' . $row['service_img'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    $query = "DELETE FROM services WHERE id='$service_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: service'); // Redirect to the service page
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
