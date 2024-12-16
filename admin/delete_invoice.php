<?php
include('../connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

  

    // Check the current status before deletion
    $stmt = $conn->prepare("SELECT status FROM invoices WHERE id=?");
    $stmt->bind_param("i", $id); // Assuming 'id' is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $invoice = $result->fetch_assoc();

    // If the invoice status is not 'Paid', delete the invoice
    if ($invoice && $invoice['status'] !== 'Paid') {
        $stmt = $conn->prepare("DELETE FROM invoices WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to invoice list
    header('Location: invoice_list.php');
    exit;
}
?>
