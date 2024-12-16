<?php
include("connection.php");

// Fetch query parameters
$bhk_type = isset($_GET['bhk_type']) ? strtoupper(trim($_GET['bhk_type'])) : null;
$property_type = isset($_GET['property_type']) ? strtoupper(trim($_GET['property_type'])) : null;
$available_for = isset($_GET['available_for']) ? strtoupper(trim($_GET['available_for'])) : null;

// Initialize the SQL query
$sql = "SELECT * FROM properties WHERE available_for = ?";

// Add filters based on parameters
if ($bhk_type && $available_for === 'RENT') {
    $sql .= " AND UPPER(bhk_type) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $available_for, $bhk_type);
} elseif ($property_type && $available_for === 'SALE') {
    $sql .= " AND UPPER(property_type) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $available_for, $property_type);
} else {
    echo "Invalid parameters provided.";
    exit;
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Display the properties
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Property Listings</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="property-table">
                <thead>
                    <tr>
                        <th>Property Name</th>
                        <th>Location</th>
                        <th>BHK Type</th>
                        <th>Property Type</th>
                        <th>Price</th>
                        <th>Available For</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['property_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['bhk_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['property_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['available_for']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No properties found for the selected criteria.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
