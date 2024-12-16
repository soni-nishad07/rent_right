<?php
include "../connection.php";

// Fetch new customer registrations (Today)
$query = "SELECT name, date FROM customer_register WHERE DATE(date) = CURDATE() ORDER BY date DESC";
$result = mysqli_query($conn, $query);
$new_registrations_count = mysqli_num_rows($result);

// Fetch old notifications (Yesterday)
$yesterday_query = "SELECT name, date FROM customer_register WHERE DATE(date) = CURDATE() - INTERVAL 1 DAY ORDER BY date DESC";
$yesterday_result = mysqli_query($conn, $yesterday_query);
$yesterday_registrations_count = mysqli_num_rows($yesterday_result);

// Function to format date as "18 Aug 2024"
function formatDate($date) {
    return date("d M Y", strtotime($date));
}

// Function to calculate how long ago the event was
function timeAgo($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

<header class="main-header">
    <a href="home" class="logo">
        <!-- Logo -->
        <span class="logo-lg">
            <img src="assets/images/logo.png" alt="">
            <h3 class="welcome-admin">Welcome Admin</h3>
        </span>
    </a>

    <nav class="navbar navbar-static-top right-navbar">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <!-- Sidebar toggle button -->
            <span class="sr-only">Toggle navigation</span>
            <span class="pe-7s-angle-left-circle"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications -->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="pe-7s-bell"></i>
                        <span class="label label-success"><?php echo $new_registrations_count; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <div class="panel panel-bd">
                            <div class="panel-body2">
                                <li>
                                    <div class="msg">
                                        <h4>Notification</h4>
                                        <p>Today</p>
                                    </div>

                                    <?php if ($new_registrations_count > 0) { ?>
                                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                            <div class="notification-msg">
                                                <a href="#" class="border-gray">
                                                    <div class="pull-left">
                                                        <span class="bell-circle">
                                                            <i class="pe-7s-bell"></i>
                                                        </span>
                                                    </div>
                                                    <span class="msg-name">
                                                        <h4>New Customer Registration: <br>
                                                            "<?php echo htmlspecialchars($row['name']); ?>"</h4>
                                                        <p style="width:100%"> <?php echo formatDate($row['date']); ?> </p>
                                                        <span class="badge badge-success"><small><?php echo timeAgo($row['date']); ?></small></span>
                                                    </span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="notification-msg">
                                            <p  class="no-found">No new customer registrations today.</p>
                                        </div>
                                    <?php } ?>

                                    <hr style="background-color:black; font-weight: 700px;" />
                                    <div class="msg">
                                        <h4>Yesterday</h4>
                                    </div>

                                    <?php if ($yesterday_registrations_count > 0) { ?>
                                        <?php while($row = mysqli_fetch_assoc($yesterday_result)) { ?>
                                            <div class="notification-msg">
                                                <a href="#" class="border-gray">
                                                    <div class="pull-left">
                                                        <span class="bell-circle">
                                                            <i class="pe-7s-bell"></i>
                                                        </span>
                                                    </div>
                                                    <span class="msg-name">
                                                        <h4>New Customer Registration: <br>
                                                            "<?php echo htmlspecialchars($row['name']); ?>"</h4>
                                                        <span class="badge badge-success"><small><?php echo formatDate($row['date']); ?>
                                                            - <?php echo timeAgo($row['date']); ?></small></span>
                                                    </span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="notification-msg">
                                            <p  class="no-found">No customer registrations yesterday.</p>
                                        </div>
                                    <?php } ?>
                                </li>
                            </div>
                        </div>
                    </ul>
                </li>

                <!-- Help -->
                <li class="dropdown dropdown-help">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="pe-7s-settings"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile">
                                <i class="fa fa-user"></i> User Profile
                            </a>
                        </li>
                        <li class="mt-10">
                            <a href="register">
                                <i class="fa fa-user-secret"></i> Administrator Register
                            </a>
                        </li>
                        <li class="mt-10">
                            <a href="changePwd">
                                <i class="fa fa-unlock-alt"></i> Change Password
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- User -->
                <li>
                    <a href="logout">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Header Navbar -->
</header>
