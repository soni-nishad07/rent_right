<?php
include('../connection.php');

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $updateQuery = "UPDATE customer_register SET status='$status' WHERE id='$id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>
                alert('Status updated successfully.');
                window.location.href = 'customer_details';
              </script>";
    } else {
        echo "<script>
                alert('Error updating status: " . $conn->error . "');
                window.location.href = 'customer_details';
              </script>";
    }
}

$conn->close();
?>
