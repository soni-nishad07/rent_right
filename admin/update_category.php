<?php
session_start();
include('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Get form data
    $id = $_POST['id'];
    $price_from = $_POST['price_from'];
    $price_to = $_POST['price_to'];
    $property_type = $_POST['property_type'];
    $bhk_type = isset($_POST['bhk_type']) ? $_POST['bhk_type'] : null; // Optional field

    // Sanitize form inputs
    $id = $conn->real_escape_string($id);
    $price_from = $conn->real_escape_string($price_from);
    $price_to = $conn->real_escape_string($price_to);
    $property_type = $conn->real_escape_string($property_type);
    $bhk_type = $bhk_type ? $conn->real_escape_string($bhk_type) : null;

    // Handle property types
    $property_choose = [];
    if (isset($_POST['property_type_rent'])) {
        $property_choose[] = 'Rent';
    }
    if (isset($_POST['property_type_buy'])) {
        $property_choose[] = 'Buy';
    }
    if (isset($_POST['property_type_commercial'])) {
        $property_choose[] = 'Commercial';
    }

    // Combine property types into a string
    $property_choose_str = implode(", ", $property_choose);

    // Prepare the UPDATE query with placeholders
    if ($bhk_type) {
        $query = "UPDATE category 
                  SET property_choose = ?, price_from = ?, price_to = ?, property_type = ?, bhk_type = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $property_choose_str, $price_from, $price_to, $property_type, $bhk_type, $id);
    } else {
        $query = "UPDATE category 
                  SET property_choose = ?, price_from = ?, price_to = ?, property_type = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $property_choose_str, $price_from, $price_to, $property_type, $id);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        header('Location: category_list.php'); // Redirect to category list after success
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
