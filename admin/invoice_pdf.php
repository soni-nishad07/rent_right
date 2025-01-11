<?php
require_once('../connection.php');
require_once 'vendor/autoload.php'; // Adjust the path if necessary

// Check if bill_no is provided
if (!isset($_GET['bill_no'])) {
    die('Bill number not provided.');
}

$billNo = $_GET['bill_no'];

// Fetch invoice data from the database
$query = "SELECT * FROM invoices WHERE bill_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $billNo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Invoice not found.');
}

$invoice = $result->fetch_assoc();

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rent Right Bangalore');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Set custom header data
$logoPath = 'assets/Logo.png'; 
$logoWidth = 30; // Adjust the logo width as needed
$title = 'Rent Right Bangalore';
$headerString = 'Invoice Header Subtitle'; // Optional, you can leave it empty or customize as needed

$pdf->SetHeaderData($logoPath, $logoWidth, $title, $headerString);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('dejavusans', '', 10);

// HTML content for invoice
$html = '
<h1>Invoice</h1>
<table border="1" cellpadding="4">
    <tr>
        <th>Bill No</th>
        <td>' . $invoice['bill_no'] . '</td>
    </tr>
    <tr>
        <th>Customer Name</th>
        <td>' . $invoice['customer_name'] . '</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>' . $invoice['address'] . '</td>
    </tr>
    <tr>
        <th>Invoice Date</th>
        <td>' . $invoice['invoice_date'] . '</td>
    </tr>
    <tr>
        <th>Due Date</th>
        <td>' . $invoice['due_date'] . '</td>
    </tr>
    <tr>
        <th>Amount</th>
        <td>' . $invoice['amount'] . '</td>
    </tr>
    <tr>
        <th>Tax</th>
        <td>' . $invoice['tax'] . '</td>
    </tr>
    <tr>
        <th>Total Amount</th>
        <td>' . $invoice['total_amount'] . '</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>' . $invoice['status'] . '</td>
    </tr>
    <tr>
        <th>Created At</th>
        <td>' . $invoice['created_at'] . '</td>
    </tr>
</table>
';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('invoice_' . $invoice['bill_no'] . '.pdf', 'I');

// Close connection
$conn->close();


?>