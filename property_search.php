<?php
session_start();
include('connection.php');

// Function to sanitize inputs
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Retrieve and sanitize search parameters
$location = sanitize($_POST['location'] ?? '');  // Assuming you want to search by city
$bhkType = sanitize($_POST['bhk_type'] ?? '');  // Assuming bhk_type is the correct column
$priceRange = sanitize($_POST['price_range'] ?? ''); // Assuming price is the column for price range

// Build the query based on search parameters
$sql = "SELECT * FROM properties WHERE city LIKE ?";  // city matches location

$params = ["%$location%"];  // Placeholder for location search

// Check if BHK type is provided and modify query
if ($bhkType) {
    $sql .= " AND bhk_type = ?";  // Assuming 'bhk_type' is the column for the BHK type
    $params[] = $bhkType;
}

// Check if price range is provided and modify query
if ($priceRange) {
    // Assuming 'price' is the column name for price in the properties table
    // Adjust the price range to use a range condition (e.g., 'price BETWEEN 10000 AND 30000')
    $priceParts = explode('-', $priceRange);
    
    if (count($priceParts) == 2) {
        $sql .= " AND price BETWEEN ? AND ?";  // Modify price query for a range
        $params[] = $priceParts[0];  // min price
        $params[] = $priceParts[1];  // max price
    }
}

// Prepare and execute the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters dynamically
$types = str_repeat('s', count($params)); // Assuming all are string types ('s' for string)
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

// Check if any properties match the search criteria
if ($result->num_rows > 0) {
    echo json_encode(['hasProperties' => true]);
} else {
    echo json_encode(['hasProperties' => false]);
}

$stmt->close();
$conn->close();
?>
