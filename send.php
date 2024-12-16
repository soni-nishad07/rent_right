<?php
require_once 'vendor/autoload.php'; // Load Composer dependencies
require_once('../connection.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $billNo = $_POST['bill_no'];
    $recipientEmail = $_POST['recipient_email'];
    $message = $_POST['message'];

    // Path to the PDF
    $pdfPath = "path/to/your/invoices/invoice_$billNo.pdf"; // Adjust according to your path

    // Check if the PDF exists
    if (!file_exists($pdfPath)) {
        echo "<script>alert('Invoice PDF not found.'); window.history.back();</script>";
        exit;
    }

    // Email setup
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.your-email-provider.com'; // Your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@example.com'; // Your email address
    $mail->Password = 'your-email-password'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // TCP port to connect to

    $mail->setFrom('your-email@example.com', 'Your Name'); // Sender
    $mail->addAddress($recipientEmail); // Recipient
    $mail->addAttachment($pdfPath); // Attach PDF invoice

    // Email content
    $mail->isHTML(true);
    $mail->Subject = "Invoice #$billNo";
    $mail->Body    = $message ? $message : 'Please find the attached invoice.';

    // Send email
    if ($mail->send()) {
        echo "<script>alert('Invoice sent successfully!'); window.location.href='invoice';</script>";
    } else {
        echo "<script>alert('Failed to send invoice: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}

?>
