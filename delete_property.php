
<?php
session_start();

// Check if the user is logged in and is an admin (modify as necessary)
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

include "../connection.php";

// Get the property ID from the URL
$property_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($property_id > 0) {
    // Prepare the delete query
    $query = "DELETE FROM properties WHERE id = $property_id";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect with a success message
        header("Location: Property_post.php");
        exit;
    } else {
        // Redirect with an error message
        header("Location: property_details.php");
        exit;
    }
} 
// Close the database connection
mysqli_close($conn);
?>
