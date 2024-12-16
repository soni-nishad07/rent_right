<?php
session_start();
include('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipientEmail = $_POST['recipient_email'];
    $billNo = $_POST['bill_no'];
    
    // Fetch invoice details from the database using $billNo
    $query = "SELECT * FROM invoices WHERE bill_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $billNo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
        
        // Prepare email content
        $subject = "Invoice No: " . $invoice['bill_no'];
        $message = "Invoice Details:\nCustomer Name: " . $invoice['customer_name'] .
                   "\nAddress: " . $invoice['address'] .
                   "\nDate: " . $invoice['date'] .
                   "\nAmount: " . $invoice['amount'] .
                   "\nTax: " . $invoice['tax'] .
                   "\nTotal Amount: " . $invoice['total_amount'];
        $headers = "From: no-reply@example.com"; // Change this to a valid sender's email
        
        // Send email
        if (mail($recipientEmail, $subject, $message, $headers)) {
            echo "Email sent successfully to $recipientEmail.";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "Invoice not found.";
    }
    
    $stmt->close();
    $conn->close();
}
?>