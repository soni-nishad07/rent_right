<?php
session_start();
require_once('../connection.php');
// require_once('../vendor/autoload.php'); // Adjust the path as needed for TCPDF

require_once 'vendor/autoload.php'; // Adjust the path if necessary
// ... rest of your code ...



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

// Handle form submission
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
    <!-- <div id="preloader">
        <div id="status"></div>
    </div> -->
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
                                        <input type="submit" class="btn btn-danger w-100" value="Generate Invoice">
                                        <br>
                                        <a href="invoice_pdf.php?bill_no=<?php echo $billNo; ?>" target="_blank">
                                        <button  type="button" class="btn btn-secondary w-100">Print Invoice</button>
                                        </a>
                                        <!--
                                        <button type="button" class="btn btn-info w-100" id="sendEmailBtn">Send Email</button>
                                        -->
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
                                        <h4>Generated Invoices</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php if ($invoices): ?>
                                    <table class="table table-bordered table-striped table-hover">
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
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($invoices as $invoice): ?>
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
                                                    <td><?php echo $invoice['created_at']; ?></td>
                                                    <td>
                                                        <a href="invoice_pdf.php?bill_no=<?php echo $invoice['bill_no']; ?>" target="_blank" class="btn btn-primary btn-sm">View PDF</a>
                                                    </td>
                               
                                                    
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No invoices found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    
        <div class="control-sidebar-bg"></div>
    </div>

    <!-- Popup structure -->
    <div id="emailPopup" class="popup">
        <div class="popup-content">
            <span id="popupClose">&times;</span>
            <h3>Send Invoice via Email</h3>
            <form method="POST" action="send_email.php">
                <input type="hidden" name="bill_no" value="<?php echo $billNo; ?>">
                <div class="form-group">
                    <label>Recipient Email</label>
                    <input type="email" name="recipient_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Email</button>
            </form>
        </div>
    </div>

             
      
    
    <script>
        document.getElementById('sendEmailBtn').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'flex';
        });
        document.getElementById('popupClose').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'none';
        });
    </script>



        <!-- footer copyright -->
        <?php
        // include('../copyright.php');
        ?>

        <?php include('footer-link.php'); ?>

</body>
</html>
