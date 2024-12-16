<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}
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
    <!--preloader-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                                                        <i class="fa fa-user-circle"></i>
                </div>
                <div class="header-title">
                    <h1>Customer Registration Details</h1>
                    <small></small>
                    <div class="searchbar">
                        <form class="search-bar" role="search" method="POST">
                            <input class="form-control me-2" type="search" name="search_query" placeholder="Search"
                                aria-label="Search">
                        </form>
    <button type="button" class="btn-reset" onclick="window.location.href='Customer_details'">
                                <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                            </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <?php
                    // Initialize search query variable
                    $search_query = '';
                    // Check if search_query is set
                    if (isset($_POST['search_query']) && !empty(trim($_POST['search_query']))) {
                        $search_query = mysqli_real_escape_string($conn, trim($_POST['search_query']));
                    }

                    // Modify the SQL query to include a WHERE clause if a search query is provided
                    $query = "SELECT * FROM customer_register";
                    if ($search_query !== '') {
                        $query .= " WHERE name LIKE '%$search_query%' OR phonenumber LIKE '%$search_query%' OR emailaddress LIKE '%$search_query%'";
                    }

                    $res = mysqli_query($conn, $query);
                    if (mysqli_num_rows($res) > 0) {
                    ?>
                    
                    <div class="col-sm-12 col-md-12">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <a href="#">
                                        <h4>Customer Details (April's 24 - August's 24)</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>Customer Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Edit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($res)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['phonenumber']; ?></td>
                                                <td><?php echo $row['emailaddress']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-add btn-xs" data-toggle="modal"
                                                        data-target="#editCustomerModal<?php echo $row['id']; ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <?php if ($row['status'] == 'active') { ?>
                                                    <button class="btn btn-warning"
                                                        onclick="updateStatus(<?php echo $row['id']; ?>, 'blocked')">Block</button>
                                                    <?php } else { ?>
                                                    <button class="btn btn-success"
                                                        onclick="updateStatus(<?php echo $row['id']; ?>, 'active')">Unblock</button>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <!-- Edit Customer Modal -->
                                            <div class="modal fade" id="editCustomerModal<?php echo $row['id']; ?>"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="editCustomerModalLabel<?php echo $row['id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header modal-header-primary">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×</button>
                                                            <h3 class="modal-title"
                                                                id="editCustomerModalLabel<?php echo $row['id']; ?>">
                                                                <i class="fa fa-user m-r-5"></i> Update Customer
                                                            </h3>
                                                        </div>


                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form class="form-horizontal"
                                                                        action="customer_editcode.php" method="post">
                                                                        <fieldset>
                                                                            <!-- Text input-->
                                                                            <div class="col-md-12 form-group">
                                                                                <label class="control-label">Customer
                                                                                    Name:</label>
                                                                                <input type="text" id="name" name="name"
                                                                                    placeholder="Customer Name"
                                                                                    value="<?php echo $row['name']; ?>"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <!-- Text input-->
                                                                            <div class="col-md-12 form-group">
                                                                                <label
                                                                                    class="control-label">Email:</label>
                                                                                <input type="email" id="emailaddress"
                                                                                    name="emailaddress"
                                                                                    class="form-control"
                                                                                    value="<?php echo $row['emailaddress']; ?>"
                                                                                    placeholder="Email"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <!-- Text input-->
                                                                           
                                                                            <div class="col-md-12 form-group">
                                                                                <label
                                                                                    class="control-label">Mobile:</label>
                                                                                <input type="number" id="phonenumber"
                                                                                    name="phonenumber"
                                                                                    value="<?php echo $row['phonenumber']; ?>"
                                                                                    placeholder="Mobile"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div
                                                                                class="col-md-12 form-group user-form-group">
                                                                                <div class="pull-right">
                                                                                    <input type="hidden" name="id"
                                                                                        value="<?php echo $row['id']; ?>">
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm"
                                                                                        data-dismiss="modal">Cancel</button>
                                                                                    <button type="submit"
                                                                                        name="customer-update"
                                                                                        class="btn btn-add btn-sm">Update</button>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger pull-left"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Edit Customer Modal -->

                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>

                                <script>
                                function updateStatus(id, status) {
                                    if (confirm('Are you sure you want to change the status?')) {
                                        window.location.href = 'update_status.php?id=' + id + '&status=' + status;
                                    }
                                }
                                </script>
                            </div>
                        </div>
                    </div>
                    <?php
        } else {
            echo '<div class="alert alert-warning">No records found</div>';
        }
        ?>
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
