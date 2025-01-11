<?php
include "../connection.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin_register WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            echo "<script>
                alert('Admin login successful');
                window.location.href='home';
                </script>";
        } else {
            echo "<script>
                alert('Wrong password');
                window.location.href='index';
                </script>";
        }
    } else {
        echo "<script>
            alert('Not registered');
            window.location.href='index';
            </script>";
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="shortcut icon" href="assets/images/favi.ico" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />
    <!-- style css -->
    <link href="assets/dist/css/stylecrm.css" rel="stylesheet" type="text/css" />
</head>

<body>

<!-- Back to Home -->
    <div class="back-link">
        <a href="../index" class="btn btn-add">Back to Home</a>
    </div>


    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">
            <div class="login-area">
                <div class="panel panel-bd panel-custom">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Administrator</h3>
                                <small><strong>Please enter a admin login.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post" >
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="Enter your username" title="Please enter you username"
                                    required="" value="" name="username" id="username" class="form-control" >
                                <span class="help-block small">Your unique username to app</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******"
                                    required="" value="" name="password" id="password" class="form-control">
                                <span class="help-block small">Your strong password</span>
                            </div>
                            <div>
                                <button class="btn btn-add" id="adminLogin"  name="login">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
 

    
    <div class="container-fluid pt-2 pb-2">
    <h6 class="text-center copyright" style="color: #000;    display: inline-block;
    text-align: center;margin:auto;
    padding: 0px 25%;">COPYRIGHT @ 2024 <b style=" color: #ff6f6f;">Rent Right Bangalore</b> . ALL RIGHTS RESERVED.
    </h6>
    </div>




    <!-- /.content-wrapper -->
    <!-- jQuery -->
    <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>