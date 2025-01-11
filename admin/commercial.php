<?php
session_start();
require_once('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php');
    exit;
}

$searchQuery = "";

// Handle search functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search']);
    $sqlSearch = "SELECT * FROM category WHERE property_choose LIKE '%$searchQuery%'";
    $result = $conn->query($sqlSearch);
} else {
    // Default query to display all categories
    $sqlSearch = "SELECT * FROM category";
    $result = $conn->query($sqlSearch);
}

// Handle form submission for inserting data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['property_type'])) {
    // Sanitize form inputs
    $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $bhk_type = isset($_POST['bhk_type']) ? mysqli_real_escape_string($conn, $_POST['bhk_type']) : null;

    // Get expected rent and deposit values
    $expected_rent_from = isset($_POST['expected_rent_from']) ? $_POST['expected_rent_from'] : null;
    $expected_rent_to = isset($_POST['expected_rent_to']) ? $_POST['expected_rent_to'] : null;

    $expected_deposit_from = isset($_POST['expected_deposit_from']) ? $_POST['expected_deposit_from'] : null;
    $expected_deposit_to = isset($_POST['expected_deposit_to']) ? $_POST['expected_deposit_to'] : null;

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

    // Prepare the INSERT query based on the available fields
    if (in_array('Rent', $property_choose)) {
        if ($bhk_type && $expected_rent_from !== null && $expected_rent_to !== null) {
            $sql = "INSERT INTO category (property_choose, expected_rent_from, expected_rent_to, bhk_type) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $property_choose_str, $expected_rent_from, $expected_rent_to, $bhk_type);
        }
    } elseif (in_array('Buy', $property_choose)) {
        if ($expected_deposit_from !== null && $expected_deposit_to !== null) {
            $sql = "INSERT INTO category (property_choose, property_type, expected_deposit_from, expected_deposit_to) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdd", $property_choose_str, $property_type, $expected_deposit_from, $expected_deposit_to);
        }
    } else {
        // For properties without specific rent or deposit details
        $sql = "INSERT INTO category (property_choose, property_type) 
                VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $property_choose_str, $property_type);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' id='alert'>New property added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' id='alert'>Error: " . $stmt->error . "</div>";
    }
    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>

