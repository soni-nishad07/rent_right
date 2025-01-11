

<?php
session_start();
include('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $total_amount = $_POST['total_amount'];
    $invoice_date = $_POST['invoice_date'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE invoices SET customer_name=?, total_amount=?, invoice_date=?, due_date=?, status=? WHERE id=?");
    
    if ($stmt->execute([$customer_name, $total_amount, $invoice_date, $due_date, $status, $id])) {
        // Set a success message in session
        $_SESSION['alert'] = "Invoice updated successfully!";
    } else {
        // Set an error message in session
        $_SESSION['alert'] = "Error updating invoice. Please try again.";
    }

    header('Location: invoice_list.php'); // Redirect back to the invoice list
    exit; // Ensure script ends after redirection
}
?>
