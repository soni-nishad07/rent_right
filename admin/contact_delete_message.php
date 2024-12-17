<?php
// Include database connection
include('../connection.php');

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM contact_messages WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Message deleted successfully!');
                window.location.href = 'Contact_detail.php'; // Redirect to the contact messages page
              </script>";
    } else {
        echo "<script>
                alert('Error deleting message: " . mysqli_error($conn) . "');
                window.location.href = 'Contact_detail.php'; // Redirect back on error
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request!');
            window.location.href = 'Contact_detail.php'; // Redirect to the contact messages page
          </script>";
}
?>
