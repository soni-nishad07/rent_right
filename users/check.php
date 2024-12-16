<?php

// check_properties.php

// Database connection
include('../connection.php');

session_start();

// Check connection
if (!$conn) {
    die(json_encode(['hasProperties' => false])); // No connection, return false
}

// Get the location and filters from query parameters
$searchLocation = isset($_GET['location']) ? trim($_GET['location']) : '';
$bhkType = isset($_GET['bhkType']) ? trim($_GET['bhkType']) : '';
$unfurnished = isset($_GET['unfurnished']) ? (bool)$_GET['unfurnished'] : false;
$semiFurnished = isset($_GET['semiFurnished']) ? (bool)$_GET['semiFurnished'] : false;
$fullyFurnished = isset($_GET['fullyFurnished']) ? (bool)$_GET['fullyFurnished'] : false;

// Prepare the base SQL query
$query = "SELECT COUNT(*) AS total FROM properties WHERE (city LIKE '%" . mysqli_real_escape_string($conn, $searchLocation) . "%' 
          OR locality LIKE '%" . mysqli_real_escape_string($conn, $searchLocation) . "%' 
          OR street LIKE '%" . mysqli_real_escape_string($conn, $searchLocation) . "%')";

// Append BHK type filter if provided
if (!empty($bhkType)) {
    $query .= " AND bhk_type = '" . mysqli_real_escape_string($conn, $bhkType) . "'";
}

// Append furnishing filters
if ($unfurnished) {
    $query .= " AND furnishing = 'Unfurnished'";
}
if ($semiFurnished) {
    $query .= " AND furnishing = 'Semi-Furnished'";
}
if ($fullyFurnished) {
    $query .= " AND furnishing = 'Fully-Furnished'";
}

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$hasProperties = $data['total'] > 0;

// Return JSON response
echo json_encode(['hasProperties' => $hasProperties]);

// Close the connection
mysqli_close($conn);


?>