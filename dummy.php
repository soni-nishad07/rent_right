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

// Fetch revenue in the last month (assuming you have a revenue column or need to calculate)
// $query_revenue_last_month = "SELECT SUM(amount) as total_revenue FROM payments WHERE payment_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
// $result_revenue_last_month = mysqli_query($conn, $query_revenue_last_month);
// $row_revenue_last_month = mysqli_fetch_assoc($result_revenue_last_month);
// $total_revenue_last_month = $row_revenue_last_month['total_revenue'];


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


// ------------------------------


// Query to get the top products based on order count in the last 5 days
$query_top_products = "
    SELECT service_name, COUNT(*) AS order_count 
    FROM bookings 
    WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 5 DAY) 
    GROUP BY service_name 
    HAVING order_count > 0
    ORDER BY order_count DESC 
    LIMIT 5
";

// Execute the query
$result_top_products = mysqli_query($conn, $query_top_products);

// Initialize an array to store the product data
$top_products = [];

// Fetch the results
while ($row = mysqli_fetch_assoc($result_top_products)) {
    $top_products[] = $row;
}


// Close the database connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>

    <?php
    include('admin-link.php');
    ?>

</head>

<body class="hold-transition sidebar-mini">
    <!--preloader-->
    <div id="preloader">
        <div id="status"></div>
    </div>
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
                        <form class="search-bar" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        </form>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row-xs-12 row-sm-6 row-md-6 row-lg-6">
                            <div class="col">
                                <div class="panel panel-bd lobidisable">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4>Check Detailed Analytics</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <canvas id="barChart" height="150"></canvas>
                                        <canvas id="singelBarChart" style="display:none"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-xs-12 row-sm-6 row-md-6 row-lg-6">
                            <div class="col">
                                <div class="panel panel-bd lobidisable">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="row-sm-6">
                                                    <div class="col-sm-4 product-name-boxs">
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
                                            <div class="col-sm-8">
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
                                                                        <h4>Within the City</h4>
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
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row-xs-12 row-sm-6 row-md-6 row-lg-6">
                            <div class="col">
                                <div class="panel panel-bd lobidisable">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4>Payment Received Monthly</h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
                                            <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
                                                <h4 class="payment-heading">Month</h4>
                                                <div class="months">
                                                    <p>January</p>
                                                    <!-- Repeat for each month -->
                                                </div>
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
                                                <h4 class="payment-heading">Total Payment</h4>
                                                <div class="payment-recive">
                                                    <p>₹400000</p>
                                                    <!-- Repeat for each month -->
                                                </div>
                                            </div>
                                            <div class="colcol-xs-1 col-sm-1 col-md-2 col-lg-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="#">Rent-Right-Banglore</a>.</strong> All rights reserved.
        </footer>
    </div>

    <?php
    include('footer-link.php');
    ?>

    <script>
    document.getElementById('logoutButton').addEventListener('click', () => {
        // Clear user data from localStorage
        localStorage.removeItem('loggedInUserId');

        // Optionally clear session storage as well
        sessionStorage.clear();

        // Redirect to login page
        window.location.href = '../login.php';
    });

    function dash() {
        // single bar chart
        var ctx = document.getElementById("singelBarChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
                datasets: [{
                    label: "My First dataset",
                    data: [40, 55, 75, 81, 56, 55, 40],
                    backgroundColor: [
                        "rgba(22, 240, 149, 0.5)",
                        "rgba(22, 240, 149, 0.5)",
                        "rgba(22, 240, 149, 0.5)",
                        "rgba(22, 240, 149, 0.5)",
                        "rgba(22, 240, 149, 0.5)",
                        "rgba(22, 240, 149, 0.5)",
                        "rgba(22, 240, 149, 0.5)"
                    ],
                    borderColor: [
                        "rgba(22, 240, 149, 1)",
                        "rgba(22, 240, 149, 1)",
                        "rgba(22, 240, 149, 1)",
                        "rgba(22, 240, 149, 1)",
                        "rgba(22, 240, 149, 1)",
                        "rgba(22, 240, 149, 1)",
                        "rgba(22, 240, 149, 1)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    dash();
    </script>

</body>

</html>