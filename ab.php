<?php
session_start();
require_once('../connection.php');
require_once 'vendor/autoload.php'; // Adjust the path if necessary

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

// Initialize bill number
$billNo = null;

// Fetch the last bill number and increment it
$query = "SELECT MAX(bill_no) AS last_bill_no FROM invoices";
$result = $conn->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $lastBillNo = $row['last_bill_no'];
    $billNo = $lastBillNo ? $lastBillNo + 1 : 1; // Start from 1 if there are no previous invoices
}

// Fetch all invoices for display
$invoices = [];
$searchQuery = isset($_POST['search']) ? $_POST['search'] : ''; // Capture search query

// Modify query based on search input
if ($searchQuery) {
    $query = "SELECT * FROM invoices WHERE customer_name LIKE ? OR address LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM invoices";
    $result = $conn->query($query);
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $invoices[] = $row; // Store each invoice in the array
    }
}

// Handle form submission for invoice generation
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($searchQuery)) {
    // Collect form data
    $customerName = $_POST['customer_name'];
    $address = $_POST['address'];
    $invoiceDate = $_POST['invoice_date'];
    $dueDate = $_POST['due_date'];
    $amount = $_POST['amount'];
    $tax = $_POST['tax'];
    $totalAmount = $amount + $tax; // Calculate total amount
    $status = $_POST['status']; // Get status from form
    $createdAt = date('Y-m-d H:i:s'); // Get the current date and time

    // Insert data into the database
    $query = "INSERT INTO invoices (customer_name, address, bill_no, invoice_date, due_date, amount, tax, total_amount, status, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssissddsss", $customerName, $address, $billNo, $invoiceDate, $dueDate, $amount, $tax, $totalAmount, $status, $createdAt);
    
    if ($stmt->execute()) {
        // Success message
        echo "<script>alert('Invoice generated successfully!');</script>";
    } else {
        echo "<script>alert('Error generating invoice. Please try again.');</script>";
    }

    $stmt->close();
}

// Handle invoice deletion
if (isset($_POST['delete_invoice'])) {
    $invoiceId = $_POST['invoice_id']; // Get the invoice ID from the form
    $deleteQuery = "DELETE FROM invoices WHERE bill_no = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $invoiceId);
    
    if ($deleteStmt->execute()) {
        echo "<script>alert('Invoice deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting invoice. Please try again.');</script>";
    }

    $deleteStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>
    <?php include('admin-link.php'); ?>
    <style>
        /* Existing styles... */
        
        /* Popup styles */
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }
        .invoice-row {
            cursor: pointer; /* Style for rows, if needed */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>
    
        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-file-text"></i>
                </div>
                
                <div class="header-title">
                    <h1>Invoice Generation</h1>
                    <small> <br /> </small>
                    <div class="searchbar">
                        <form class="search-bar" method="POST" role="search">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search by Account" aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='invoice'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <a href="#">
                                        <h4>Generate a new Invoice </h4>
                                    </a>
                                </div>
                                <a href="invoice_list" class="btn btn-danger c-p-invoice">Check Previous Invoices</a>
                            </div>
                            <div class="panel-body">
                                <form class="col-sm-10" method="POST" action="">
                                    <div class="form-group">
                                        <label>Customer Name <span style="color:red;">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Address <span style="color:red;">*</span></label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Bill No <span style="color:red;">*</span></label>
                                        <input type="number" name="bill_no" class="form-control" value="<?php echo $billNo; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Invoice Date <span style="color:red;">*</span></label>
                                        <input type="date" name="invoice_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Due Date <span style="color:red;">*</span></label>
                                        <input type="date" name="due_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount <span style="color:red;">*</span></label>
                                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tax</label>
                                        <input type="number" name="tax" class="form-control" placeholder="Enter Tax" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Total Amount <span style="color:red;">*</span></label>
                                        <input type="number" name="total_amount" class="form-control" placeholder="Auto Filled By Calculated" value="<?php echo isset($totalAmount) ? $totalAmount : ''; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Status <span style="color:red;">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="Unpaid">Unpaid</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Overdue">Overdue</option>
                                        </select>
                                    </div>
                                    <div class="ginvoice-submit-button">
                                        <input type="submit" class="btn btn-success" value="Generate Invoice">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <a href="#">
                                        <h4>Invoices List</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="invoices" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Customer Name</th>
                                            <th>Address</th>
                                            <th>Invoice Date</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Tax</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($invoices as $invoice) { ?>
                                            <tr>
                                                <td><?php echo $invoice['bill_no']; ?></td>
                                                <td><?php echo $invoice['customer_name']; ?></td>
                                                <td><?php echo $invoice['address']; ?></td>
                                                <td><?php echo $invoice['invoice_date']; ?></td>
                                                <td><?php echo $invoice['due_date']; ?></td>
                                                <td><?php echo $invoice['amount']; ?></td>
                                                <td><?php echo $invoice['tax']; ?></td>
                                                <td><?php echo $invoice['total_amount']; ?></td>
                                                <td><?php echo $invoice['status']; ?></td>
                                                <!-- <td>
                                                    <a href="invoice_pdf.php?bill_no=<?php echo $invoice['bill_no']; ?>" target="_blank" class="btn btn-primary btn-sm">View PDF</a>
                                                    <button class="btn btn-danger btn-sm" data-invoice-id="<?php echo $invoice['bill_no']; ?>" onclick="confirmDelete(this)">Send Invoice</button>
                                                </td> -->
                                                <td>
    <a href="invoice_pdf.php?bill_no=<?php echo $invoice['bill_no']; ?>" target="_blank" class="btn btn-primary btn-sm">View PDF</a>
    <button class="btn btn-danger btn-sm" data-invoice-id="<?php echo $invoice['bill_no']; ?>" onclick="openEmailPopup(<?php echo $invoice['bill_no']; ?>)">Send Invoice</button>
</td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div id="emailPopup" class="popup">
        <div class="popup-content">
            <h4>Send Invoice via Email</h4>
            <form id="sendEmailForm" method="POST" action="send.php">
                <input type="hidden" name="bill_no" id="invoiceBillNo" value="">
                <div class="form-group">
                    <label for="recipient_email">Recipient Email:</label>
                    <input type="email" name="recipient_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Send Email</button>
                <button type="button" onclick="closePopup()" class="btn btn-danger">Close</button>
            </form>
        </div>
    </div>

    <script>
        function confirmDelete(button) {
            const invoiceId = button.getAttribute('data-invoice-id');
            if (confirm('Are you sure you want to delete this invoice?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_invoice';
                input.value = 'true'; // For confirmation
                form.appendChild(input);
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'invoice_id';
                idInput.value = invoiceId;
                form.appendChild(idInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function openEmailPopup(billNo) {
            document.getElementById('invoiceBillNo').value = billNo;
            document.getElementById('emailPopup').style.display = 'flex'; // Show popup
        }

        function closePopup() {
            document.getElementById('emailPopup').style.display = 'none'; // Hide popup
        }
    </script>
</body>
</html>
