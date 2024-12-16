<?php
include('connection.php');

$city = isset($_POST['location']) ? sanitize($_POST['location']) : '';
$bhk_type = isset($_POST['bhk_type']) ? sanitize($_POST['bhk_type']) : '';
$budget = isset($_POST['budget']) ? sanitize($_POST['budget']) : '';

// Fetch properties matching city, bhk type, and budget
$query = "SELECT * FROM properties WHERE city = '$city' AND bhk_type = '$bhk_type' AND budget <= '$budget'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Display the matching properties
    }
} else {
    echo "No properties found matching your criteria.";
}
?>
