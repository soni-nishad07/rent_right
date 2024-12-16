<?php
include "../connection.php";
session_start();

if (isset($_POST['admin_register'])) {
    // Sanitize and validate input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confpassword = mysqli_real_escape_string($conn, $_POST['confpassword']);

    // Check if password and confirm password match
    if ($password !== $confpassword) {
        echo "Passwords do not match.";
        
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query
        $query = "INSERT INTO `admin_register` (`username`, `email`, `password` ) 
                  VALUES ('$username', '$email', '$hashed_password'  )";

        // Execute query
        $res = mysqli_query($conn, $query);

        if ($res) {
            // Registration successful
            echo "<script>alert('Registration successful');
                  window.location.href='index';</script>";
            exit; // Stop further execution
        } else {
            // Registration failed
            echo "<script>alert('Registration failed: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Register</title>
    <link rel="shortcut icon" href="assets/images/favi.ico" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />
    <!-- style css -->
    <link href="assets/dist/css/stylecrm.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <!-- Content Wrapper -->
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
                                    <input type="text" value="" id="username" class="form-control" name="username">
                                    <span class="help-block small">Your unique username to app</span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Email Address</label>
                                    <input type="text" value="" id="email" class="form-control" name="email">
                                    <span class="help-block small">Your address email to contact</span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Password</label>
                                    <input type="password" value="" id="password" class="form-control" name="password">
                                    <span class="help-block small">Your hard to guess password</span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Confirm Password</label>
                                    <input type="password" value="" id="confpassword" class="form-control" name="confpassword">
                                    <span class="help-block small">Please repeat your password</span>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-warning" id="admin_register" name="admin_register">Register</button>
                                <!-- <a class="btn btn-add" href="login.php">Login</a> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <!-- jQuery -->
    <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>

