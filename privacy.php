<?php
session_start();
include('connection.php');

$is_logged_in = isset($_SESSION['user_id']); 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Right Bangalore</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/service_modal.css">
    <link rel="shortcut icon" href="admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places">
    </script>
    <?php include('links.php'); ?>
</head>


<body>



        <?php 
            include('head.php');
        ?>



    <header class="header"  style="background: url('img/home2.png') center/cover no-repeat;">
         <h2 class="brdcrum">Privacy</h2>
    </header>



        <!-- footer start  -->
        <?php include('footer.php'); ?>

<script src="js/script.js"></script>
    </body>

