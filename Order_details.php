<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index');
    exit;
}

include('../connection.php'); // Ensure you include your database connection

// Handle status update
if (isset($_POST['update_status'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    $update_query = "UPDATE bookings SET booking_status='$new_status' WHERE booking_id='$booking_id'";
    mysqli_query($conn, $update_query);
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

    <style>



/* Styles for the status labels */
    .status-complete {
        background-color: #28a745;
        /* Green */
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .status-cancel {
        background-color: #dc3545;
        /* Red */
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .status-pending {
        background-color: #ffc107;
        /* Yellow */
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div id="preloader">
        <div id="status"></div>
    </div>
    <div class="wrapper">

        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">

                        <div class="header-icon">
                    <i class="fa fa-bitbucket-square"></i>
                </div>
                
                <div class="header-title">
                    <h1>Order Received Details</h1>
                    <small> <br /> </small>

                    <div class="searchbar">
                        <form class="search-bar" method="POST" action="">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                                    <button type="button" class="btn-reset" onclick="resetSearch()">
                                <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                            </button>
                        
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="panel">
                                <div class="col-sm-4 o-month">
                                    <h4 class="text-center">Order Received</h4>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-6">
                                    <form method="POST" action="">
                                        <input type="date" name="from_date" class="btn btn-add gray-border"
                                            title="From Date" placeholder="From Date">
                                        <input type="date" name="to_date" class="btn btn-add gray-border"
                                            title="To Date" placeholder="To Date">
                                        <button type="submit" class="btn btn-add red"> <i class="fa fa-check"></i>
                                            Apply</button>
     <button type="reset" class="btn btn-add red-border" onclick="window.location.href='Order_details'"> Reset</button>                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php
                        $search_query = "";
                        if (isset($_POST['search'])) {
                            $search_query = mysqli_real_escape_string($conn, $_POST['search']);
                        }

                        $from_date = "";
                        $to_date = "";
                        if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
                            $from_date = $_POST['from_date'];
                            $to_date = $_POST['to_date'];
                        }

                        $query = "SELECT * FROM bookings WHERE 
                                  (booking_id LIKE '%$search_query%' OR 
                                  name LIKE '%$search_query%' OR 
                                  mobile LIKE '%$search_query%' OR 
                                  address LIKE '%$search_query%' OR 
                                  service_name LIKE '%$search_query%' OR 
                                  booking_date LIKE '%$search_query%' OR 
                                  payment_mode LIKE '%$search_query%' OR 
                                  booking_status LIKE '%$search_query%')";

                        if ($from_date != "" && $to_date != "") {
                            $query .= " AND booking_date BETWEEN '$from_date' AND '$to_date'";
                        }

                        $res = mysqli_query($conn, $query);
                        if (mysqli_num_rows($res) > 0) {
                        ?>
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Mobile Number</th>
                                                <th>Booking Service</th>
                                                <th>Booking Date</th>
                                                <th>Status</th>
                                                <th>Update Status</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    // Determine the status class based on the booking status
                                                    $status_class = '';
                                                    if ($row['booking_status'] == 'Complete') {
                                                        $status_class = 'status-complete';
                                                    } elseif ($row['booking_status'] == 'Cancel') {
                                                        $status_class = 'status-cancel';
                                                    } else {
                                                        $status_class = 'status-pending';
                                                    }
                                                ?>
                                            <tr>
                                                <td><?php echo $row['booking_id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['mobile']; ?></td>
                                                <td><?php echo $row['service_name']; ?></td>
                                                <td><?php echo $row['booking_date']; ?></td>
                                                <td>
                                                    <span class="label-custom label <?php echo $status_class; ?>"  style="border:0px">
                                                        <?php echo $row['booking_status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <form method="POST" action="">
                                                        <input type="hidden" name="booking_id"
                                                            value="<?php echo $row['booking_id']; ?>">
                                                        <select name="status" class="form-control" required  style="height:35pxpx;border:0px;    margin: 10px 0px;">
                                                            <option value="" disabled selected>Select Status</option>
                                                            <option value="Complete">Complete</option>
                                                            <option value="Cancel">Cancel</option>
                                                        </select>
                                                        <button type="submit" name="update_status"
                                                            class="btn btn-add">Update</button>
                                                    </form>
                                                </td>


                                                <td>
                <!-- Delete form -->
                <form method="POST" action="">
                    <input type="hidden" name="delete_booking_id" value="<?php echo $row['booking_id']; ?>">
                    <button type="submit" name="delete_booking" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?');">
                        Delete
                    </button>
                </form>
            </td>

                                            </tr>
                                            <?php
                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                        } else {
                            echo "<p>No records found</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>

     

        <?php
// Handle delete booking
if (isset($_POST['delete_booking'])) {
    $delete_booking_id = $_POST['delete_booking_id'];

    // Delete query to remove the booking from the database
    $delete_query = "DELETE FROM bookings WHERE booking_id='$delete_booking_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Booking deleted successfully.');</script>";
        echo "<script>window.location.href = 'Order_details'</script>"; // Reload page to reflect changes
    } else {
        echo "Error deleting booking: " . mysqli_error($conn);
    }
}
?>


         <!-- footer copyright -->
        <?php
include('copy.php');
    ?>

    </div>

    <?php include('footer-link.php'); ?>

</body>

</html>
