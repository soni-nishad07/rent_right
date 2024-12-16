<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index');
    exit;
}

include "../connection.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['c_pass'];

    if ($password !== $confirm_password) {
        echo "<script>
            alert('Passwords do not match.');
            window.location.href='register';
            </script>";
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO admin_register (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Admin registration successful');
            window.location.href='index';
            </script>";
    } else {
        echo "<script>
            alert('Registration failed. Please try again.');
            window.location.href='register';
            </script>";
    }

    $stmt->close();
    $conn->close();
}
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

<!--=====================================================================-->





<body class="hold-transition sidebar-mini">
    <!--preloader-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">



        <?php
        include('header.php');
        ?>

        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->
        <?php
        include('sidebar.php');
        ?>



        <!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-sticky-note-o"></i>
                </div>
                <div class="header-title">
                    <h1>New Register</h1>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- Form controls -->
                    <div class="col-sm-12">
                        <div class="login-wrapper">
                            <div class="container-center lg">
                                <div class="login-area">
                                    <div class="panel panel-bd panel-custom">
                                        <div class="panel-heading">
                                            <div class="view-header">
                                                <div class="header-icon">
                                                    <i class="pe-7s-unlock"></i>
                                                </div>
                                                <div class="header-title">
                                                    <h3>Administrator Register</h3>
                                                    <small><strong>Please enter your data to register.</strong></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label>Username</label>
                                                        <input type="text" value="" id="username" class="form-control"  
                                                            name="username"  required>
                                                        <span class="help-block small">Your unique username to
                                                            app</span>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Email Address</label>
                                                        <input type="text" value="" id="email" class="form-control"
                                                            name="email"  required>
                                                        <span class="help-block small">Your address email to
                                                            contact</span>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Password</label>
                                                        <input type="password" value="" id="password"
                                                            class="form-control" name="password">
                                                        <span class="help-block small"  required>Your hard to guess
                                                            password</span>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Confirm Password</label>
                                                        <input type="password" value="" id="c_pass"
                                                            class="form-control" name="c_pass" required>
                                                        <span class="help-block small" >Please repeat your
                                                            password</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-warning" id="admin_register"
                                                        name="submit">Register</button>
                                                    <!-- <a class="btn btn-add" href="login.php">Login</a> -->
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.content-wrapper -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
              
         <!-- footer copyright -->
        <?php
include('copy.php');
    ?>
    </div>
    <!-- /.wrapper -->

    <?php
    include('footer-link.php');
    ?>

</body>


</html>
