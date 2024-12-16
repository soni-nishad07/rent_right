<?php
session_start();
include('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

// Check if a search query was submitted
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);
    $result = $conn->query("SELECT * FROM invoices WHERE customer_name LIKE '%$searchQueryEscaped%'");
} else {
    // Fetch all invoices if no search query
    $result = $conn->query("SELECT * FROM invoices");
}
$invoices = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>
    <?php include('admin-link.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-sticky-note-o"></i>
                </div>
                <div class="header-title">
                    <h1>Invoice Generation List</h1>
                    <div class="searchbar">
                        <form class="search-bar" method="POST" role="search">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search by Account" aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        </form>
       <button type="button" class="btn-reset" onclick="window.location.href='invoice_list'">
                                <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                            </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonexport">
                                    <h4>Invoices</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>#</th>
                                                <th>Account</th>
                                                <th>Amount</th>
                                                <th>Invoice Date</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($invoices as $invoice): ?>
                                            <tr>
                                                <td><?php echo $invoice['id']; ?></td>
                                                <td><?php echo htmlspecialchars($invoice['customer_name']); ?></td>
                                                <td><?php echo 'Rs' . number_format($invoice['total_amount'], 2); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($invoice['invoice_date'])); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($invoice['due_date'])); ?></td>
                                                <td><span class="label-custom label label-default"><?php echo htmlspecialchars($invoice['status']); ?></span></td>
                                                <td>
                                                    <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#updateModal<?php echo $invoice['id']; ?>"><i class="fa fa-pencil"></i></button>
                                                    <?php if ($invoice['status'] !== 'Paid'): ?>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo $invoice['id']; ?>"><i class="fa fa-trash-o"></i></button>
                                                    <?php else: ?>
                                                    <button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash-o"></i> Paid</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <!-- Update Modal -->
                                            <div class="modal fade" id="updateModal<?php echo $invoice['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header modal-header-primary">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3><i class="fa fa-user m-r-5"></i> Update Invoice</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal" action="update_invoice.php" method="POST">
                                                                <input type="hidden" name="id" required value="<?php echo $invoice['id']; ?>">
                                                                <div class="form-group">
                                                                    <label class="control-label">Account:</label>
                                                                    <input type="text" required name="customer_name" value="<?php echo htmlspecialchars($invoice['customer_name']); ?>" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Amount</label>
                                                                    <input type="text" required name="total_amount" value="<?php echo $invoice['total_amount']; ?>" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Invoice Date</label>
                                                                    <input type="date" name="invoice_date" value="<?php echo $invoice['invoice_date']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Due Date</label>
                                                                    <input type="date" name="due_date" value="<?php echo $invoice['due_date']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Status</label>
                                                                    <select name="status" class="form-control">
                                                                        <option value="Active" <?php echo ($invoice['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                                                        <option value="Paid" <?php echo ($invoice['status'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                                                                        <option value="Unpaid" <?php echo ($invoice['status'] == 'Unpaid') ? 'selected' : ''; ?>>UnPaid</option>
                                                                        <option value="Overdue" <?php echo ($invoice['status'] == 'Overdue') ? 'selected' : ''; ?>>Overdue</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-add">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal<?php echo $invoice['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header modal-header-danger">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3><i class="fa fa-user m-r-5"></i> Delete Invoice</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="delete_invoice.php" method="POST">
                                                                <input type="hidden" name="id" value="<?php echo $invoice['id']; ?>">
                                                                <p>Are you sure you want to delete this invoice?</p>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>
                                                                    <button type="submit" class="btn btn-add">Yes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
  

         
         <!-- footer copyright -->
        <?php
include('copy.php');
    ?>

    </div>
    <?php include('footer-link.php'); ?>
</body>

</html>
