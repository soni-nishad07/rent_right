<?php
include('../connection.php');

// Function to sanitize inputs
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Retrieve and sanitize search parameters
$location = sanitize($_GET['location'] ?? '');
$bhkType = sanitize($_GET['bhkType'] ?? '');
$propertyType = sanitize($_GET['propertyType'] ?? ''); // Added propertyType parameter
$unfurnished = isset($_GET['unfurnished']) ? 1 : 0;
$semiFurnished = isset($_GET['semiFurnished']) ? 1 : 0;
$fullyFurnished = isset($_GET['fullyFurnished']) ? 1 : 0;
$priceRange = sanitize($_GET['price_range'] ?? ''); // Added price_range parameter

// Build the query based on search parameters
$sql = "SELECT * FROM properties WHERE city LIKE ?";

// Parameters array
$params = ["%$location%"];

// Handle price range filtering
if ($priceRange) {
    // Split price range into min and max values
    list($minPrice, $maxPrice) = explode('-', $priceRange);
    
    // Check if 'above' is in the max price value
    if ($maxPrice === 'above') {
        $sql .= " AND price >= ?";
        $params[] = $minPrice;
    } else {
        $sql .= " AND price BETWEEN ? AND ?";
        $params[] = $minPrice;
        $params[] = $maxPrice;
    }
}

if ($propertyType) {
    $sql .= " AND property_type = ?";
    $params[] = $propertyType;
}

if ($bhkType) {
    $sql .= " AND bhk_type = ?";
    $params[] = $bhkType;
}

if ($unfurnished || $semiFurnished || $fullyFurnished) {
    $furnishingConditions = [];
    if ($unfurnished) $furnishingConditions[] = "furnishing = 'Unfurnished'";
    if ($semiFurnished) $furnishingConditions[] = "furnishing = 'Semi-Furnished'";
    if ($fullyFurnished) $furnishingConditions[] = "furnishing = 'Fully-Furnished'";

    if (!empty($furnishingConditions)) {
        $sql .= " AND (" . implode(' OR ', $furnishingConditions) . ")";
    }
}

// Prepare and execute the SQL statement
$stmt = $conn->prepare($sql);

// Determine the types for bind_param
$types = str_repeat('s', count($params));

// Bind parameters dynamically
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
