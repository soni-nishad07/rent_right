<?php
session_start();
include('../connection.php');

// Sanitize function to prevent SQL Injection
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Get and sanitize URL parameters
$bhk_type = isset($_GET['bhk_type']) ? sanitize($_GET['bhk_type']) : '';
$available_for = isset($_GET['available_for']) ? sanitize($_GET['available_for']) : '';

// Check if the URL parameters match the desired values
if ($bhk_type && $available_for) {
    // Prepare SQL query to get the properties matching the criteria
    $sql = "SELECT * FROM properties WHERE bhk_type = ? AND available_for = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind the parameters to the query
        $stmt->bind_param("ss", $bhk_type, $available_for);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any properties match
        if ($result->num_rows > 0) {
            // Loop through and display properties
            while ($row = $result->fetch_assoc()) {
                echo "<div class='property'>";
                echo "<h3>Property ID: " . $row["id"] . "</h3>";
                echo "<p>BHK Type: " . $row["bhk_type"] . "</p>";
                echo "<p>Available for: " . $row["available_for"] . "</p>";
                echo "<p>Location: " . $row["location"] . "</p>";
                echo "<p>Price: ₹" . $row["price"] . "</p>";
                echo "<p>Description: " . $row["description"] . "</p>";
                echo "<a href='property_details.php?id=" . $row["id"] . "'>View Details</a>";
                echo "</div>";
            }
        } else {
            echo "No properties match the given criteria.";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement.";
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid parameters.";
}
?>
