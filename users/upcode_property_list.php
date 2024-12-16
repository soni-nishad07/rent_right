<?php
include('../connection.php');
include('session_check.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the property ID from the URL
    $property_id = $_GET['id'];

    // Function to sanitize inputs
    function sanitize($data, $conn) {
        return mysqli_real_escape_string($conn, trim($data));
    }

    // Retrieve and sanitize form data
    $available_for = implode(',', $_POST['available_for']); // Handle array of checkboxes
    $property_type = sanitize($_POST['property_type'], $conn);
    $available_from = sanitize($_POST['available_from'], $conn);
    $bhk_type = sanitize($_POST['bhk_type'], $conn);
    $furnishing = sanitize($_POST['furnishing'], $conn);
    $build_up_area = sanitize($_POST['build_up_area'], $conn);
    $expected_rent = sanitize($_POST['expected_rent'], $conn);
    $expected_deposit = sanitize($_POST['expected_deposit'], $conn);

    $area = sanitize($_POST['area'], $conn);
    $city = sanitize($_POST['city'], $conn);
    $state = sanitize($_POST['state'], $conn);


    $bathrooms = sanitize($_POST['bathrooms'], $conn);
    $balcony = sanitize($_POST['balcony'], $conn);
    $water_supply = sanitize($_POST['water_supply'], $conn);
    $property_age = sanitize($_POST['property_age'], $conn);
    $floor = sanitize($_POST['floor'], $conn);
    $total_floor = sanitize($_POST['total_floor'], $conn);
    $amenities = implode(',', $_POST['amenities']); // Handle array of checkboxes
    $description = sanitize($_POST['description'], $conn);

    // Handle image uploads
    $image_paths = [];
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'][0] != UPLOAD_ERR_NO_FILE) {
        foreach ($_FILES['file_upload']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['file_upload']['error'][$key] == UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['file_upload']['tmp_name'][$key];
                $file_name = $_FILES['file_upload']['name'][$key];
                $file_path = '../uploads/' . basename($file_name);
                
                // Move the uploaded file to the desired directory
                if (move_uploaded_file($file_tmp, $file_path)) {
                    $image_paths[] = $file_path; // Save the file path for the database
                }
            }
        }
    }

    // Convert the image paths array to a comma-separated string
    $file_upload = !empty($image_paths) ? implode(',', $image_paths) : '';

    // Update the property details in the database
    $update_query = "UPDATE properties SET 
        available_for = '$available_for',
        property_type = '$property_type',
        available_from = '$available_from',
        bhk_type = '$bhk_type',
        furnishing = '$furnishing',
        build_up_area = '$build_up_area',
        expected_rent = '$expected_rent',
        expected_deposit = '$expected_deposit',
        area = '$area',
        city = '$city',
        state = '$state',
        bathrooms = '$bathrooms',
        balcony = '$balcony',
        water_supply = '$water_supply',
        property_age = '$property_age',
        floor = '$floor',
        total_floor = '$total_floor',
        amenities = '$amenities',
        description = '$description'";

    // Add image upload if it exists
    if (!empty($file_upload)) {
        $update_query .= ", file_upload = '$file_upload'";
    }

    $update_query .= " WHERE id = '$property_id'";

    // Execute the update query
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Property updated successfully!'); window.location.href='property_list.php';</script>";
    } else {
        echo "Error updating property: " . mysqli_error($conn);
    }
}
?>
