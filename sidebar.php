<?php
// Get the current script name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- sidebar menu -->
        <ul class="sidebar-menu">
            <li class="treeview <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">
                <a href="home">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview <?php echo ($current_page == 'Customer_details.php') ? 'active' : ''; ?>">
                <a href="Customer_details">
                    <i class="fa fa-users"></i>

                    <span>Customer Registration
                        <br />
                        details</span>
                </a>
            </li>
            <li class="treeview <?php echo ($current_page == 'Property_post.php') ? 'active' : ''; ?>">
                <a href="Property_post">
                    <i class="fa fa-home"></i>
                    <span>Property Posted
                        <br />
                        Details</span>
                </a>
            </li>
            <li class="treeview <?php echo ($current_page == 'service.php') ? 'active' : ''; ?>">
                <a href="service">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="treeview <?php echo ($current_page == 'Order_details.php') ? 'active' : ''; ?>">
                <a href="Order_details">
                    <i class="fa fa-file-text"></i>
                    <span>Order Received</span>
                </a>
            </li>

            <li class="treeview <?php echo ($current_page == 'Invoice.php') ? 'active' : ''; ?>">
                <a href="Invoice">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Invoice Generation</span>
                </a>
            </li>

            <li class="treeview <?php echo ($current_page == 'footer.php') ? 'active' : ''; ?>">
                <a href="footer">
                    <i class="fa fa-gear"></i>
                    <span>Footer</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar -->
</aside>