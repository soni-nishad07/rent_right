<?php
// Include the database connection
include('connection.php');

// Start the session
session_start();

// Clear session data
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Optionally clear session data in the database (if implemented)
    $logoutQuery = "UPDATE customer_register SET session_id = NULL WHERE id = ?";
    $stmt = $conn->prepare($logoutQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page with an alert
echo "<script>
    alert('Logout successful');
    window.location.href = 'index';
</script>";

exit();
?>
