<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

include('../connection.php'); // Ensure you have a file to handle DB connection

// Fetch total number of customers
$query_total_customers = "SELECT COUNT(*) as total_customers FROM customer_register WHERE status = 'active'";
$result_total_customers = mysqli_query($conn, $query_total_customers);
$row_total_customers = mysqli_fetch_assoc($result_total_customers);
$total_customers = $row_total_customers['total_customers'];

// Fetch total number of orders in the last month
$query_orders_last_month = "SELECT COUNT(*) as total_orders FROM bookings WHERE booking_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$result_orders_last_month = mysqli_query($conn, $query_orders_last_month);
$row_orders_last_month = mysqli_fetch_assoc($result_orders_last_month);
$total_orders_last_month = $row_orders_last_month['total_orders'];

// --------------------------Total revenue------------

$query_total_paid_invoices = "
    SELECT SUM(total_amount) AS total_paid 
    FROM invoices 
    WHERE status = 'Paid'
";

// Execute the query
$result_total_paid_invoices = mysqli_query($conn, $query_total_paid_invoices);

// Fetch the result
$row_total_paid_invoices = mysqli_fetch_assoc($result_total_paid_invoices);

// Get the total paid amount
$total_paid_amount = $row_total_paid_invoices['total_paid'];


// --------------------------TOP PRODUCTS----------

// Search functionality
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';


// Query to get the top products based on order count in the last 5 days with search filter
$query_top_products = "
    SELECT address, service_name, COUNT(*) AS order_count 
    FROM bookings 
    WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 5 DAY) 
    AND service_name LIKE '%$search_query%'
    GROUP BY service_name 
    HAVING order_count > 0
    ORDER BY order_count DESC 
    LIMIT 5
";

// Query to get the top products based on order count in the last 5 days

// $query_top_products = "
//     SELECT address , service_name, COUNT(*) AS order_count 
//     FROM bookings 
//     WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 5 DAY) 
//     GROUP BY service_name 
//     HAVING order_count > 0
//     ORDER BY order_count DESC 
//     LIMIT 5
// ";

// Execute the query
$result_top_products = mysqli_query($conn, $query_top_products);

// Initialize an array to store the product data
$top_products = [];

// Fetch the results
while ($row = mysqli_fetch_assoc($result_top_products)) {
    $top_products[] = $row;
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    include('admin-link.php');
    ?>

</head>

<body class="hold-transition sidebar-mini">
    <!--preloader-->
    <!-- <div id="preloader">
        <div id="status"></div>
    </div> -->
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php
        include('header.php');
        include('sidebar.php');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-dashboard"></i>
                </div>
                <div class="header-title">
                    <h1>Overview</h1>
                    <small> <br /> </small>
                    <div class="searchbar">
                        <form method="GET" action="" class="search-bar-home">
                            <input class="form-control me-2" type="search" name="search"
                                placeholder="Search by service name" aria-label="Search"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            </form>
                            <button type="button" class="btn-reset" onclick="resetSearch()">
                                <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                            </button>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">


                        <div class="row-xs-12 row-sm-6 row-md-6 row-lg-6">
                            <div class="col">
                                <div class="panel panel-bd panel-shadow">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4>Check Detailed Analytics</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <canvas id="barChart" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row-xs-12 row-sm-6 row-md-6 row-lg-6">
                            <div class="col">
                                <div class="panel panel-bd ">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class=" col-sm-12 col-lg-4  col-md-12">
                                                <div class="row-sm-6">
                                                    <div class="col product-name-boxs">
                                                        <div id="cardbox1">
                                                            <div class="statistic-box">
                                                                <h3>Customers</h3>
                                                                <p><?php echo $total_customers; ?></p>
                                                                <div class="last">In last 1 month</div>
                                                            </div>
                                                        </div>
                                                        <div id="cardbox1">
                                                            <div class="statistic-box">
                                                                <h3>Orders</h3>
                                                                <p><?php echo $total_orders_last_month; ?></p>
                                                                <div class="last">In last 1 month</div>
                                                            </div>
                                                        </div>
                                                        <div id="cardbox1">
                                                            <div class="statistic-box">
                                                                <h3>Revenue</h3>
                                                                <p>₹<?php echo $total_paid_amount ? number_format($total_paid_amount, 2) : '0.00'; ?>
                                                                </p>
                                                                <div class="last">Total of Paid </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-lg-8  col-md-12">
                                                <div class="row">
                                                    <div class="col product-name">
                                                        <div class="panel panel-shadow panel-bd">
                                                            <div class="panel-body2">
                                                                <div class="msg">
                                                                    <h4>Top Products</h4>
                                                                </div>
                                                                <?php if (count($top_products) > 0): ?>
                                                                <?php foreach ($top_products as $product): ?>
                                                                <div id="cardbox2">
                                                                    <div class="statistic-box">
                                                                        <h3><?php echo htmlspecialchars($product['service_name']); ?>
                                                                        </h3>
                                                                        <h6><?php echo $product['address']; ?></h6>
                                                                        <!-- Modify as needed -->
                                                                        <div class="last">
                                                                            <?php echo $product['order_count']; ?>
                                                                            orders placed in the last 5 days</div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
                                                                <?php else: ?>
                                                                <div id="cardbox2">
                                                                    <div class="statistic-box">
                                                                        <h3>No bookings found</h3>
                                                                        <div class="last">No services were booked in the
                                                                            last 5 days.</div>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                        <div class="row-xs-12 row-sm-6 row-md-6 row-lg-6">
                            <div class="col">
                                <div class="panel panel-bd panel-shadow">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4>Order Received</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
                                            <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
                                                <h4 class="payment-heading"> Orders</h4>
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
                                                <h4 class="payment-heading">Total Received</h4>
                                            </div>
                                        </div>
                                        <?php
                                    // Fetch data grouped by service_name
                                    $sql = "SELECT service_name, COUNT(*) AS total_orders
                                            FROM bookings 
                                            GROUP BY service_name";
                                    $result =mysqli_query(  $conn,$sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                    ?>
                                        <div class="row">
                                            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
                                            <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
                                                <div class="months">
                                                    <p><?php echo $row['service_name']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
                                                <!-- <h4 class="payment-heading">Total Received</h4> -->
                                                <div class="payment-recive">
                                                    <p><?php echo number_format($row['total_orders']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<div class='no_record'>No records found.</div>";
                                }
                                
                                // $mysqli->close();
                                ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>







                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

                 
         <!-- footer copyright -->
        <?php
include('copy.php');
    ?>
        
    </div>




    <script>
    document.getElementById('logoutButton').addEventListener('click', () => {
        // Clear user data from localStorage
        localStorage.removeItem('loggedInUserId');

        // Optionally clear session storage as well
        sessionStorage.clear();

        // Redirect to login page
        window.location.href = '../login.php';
    });


        // reset searxh
        function resetSearch() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('form.search-bar-home').submit();
    }


    </script>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
    function chartlist() {
        "use strict";

        $.ajax({
            url: 'fetch_data.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var months = [];
                var totalOrders = [];
                var completeOrders = [];

                // Process the data
                for (var i = 0; i < data.length; i++) {
                    var monthIndex = data[i].month - 1; // Convert month number to zero-based index
                    months.push(monthNames[monthIndex]); // Map to month name
                    totalOrders.push(data[i].total_order);
                    completeOrders.push(data[i].complete);
                }

                // Create the chart
                var ctx = document.getElementById("barChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: "Total Orders",
                                data: totalOrders,
                                borderColor: "rgba(0, 150, 136, 0.76)",
                                borderWidth: 1,
                                backgroundColor: "rgba(0, 150, 136, 0.76)"
                            },
                            {
                                label: "Completed Orders",
                                data: completeOrders,
                                borderColor: "rgba(255, 99, 132, 0.76)",
                                borderWidth: 1,
                                backgroundColor: "rgba(255, 99, 132, 0.76)"
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + status + " " + error);
            }
        });
    }
    chartlist();
});
</script>
    <?php include('footer-link.php'); ?>


</body>

</html>
