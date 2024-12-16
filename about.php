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


    <header class="header" style="background: url('img/home2.png') center/cover no-repeat;">
        <h2 class="brdcrum">About us</h2>
    </header>




    <!-- -------------ABOUT US------------------ -->

    <section class="about-section">

        <div class="head">
            <h2 class="our-services-title">About Us</h2>
        </div>

        <div class="container">
            <div class="about">
                <p>
                    At Rent Right Services, we are dedicated to providing comprehensive, personalized solutions for all your real estate needs. Whether you're looking to rent, buy, sell, or relocate, our experienced team is here to make your journey as smooth and stress-free as possible.
    
                    With a deep understanding of the local market and a commitment to delivering exceptional customer service, we take the time to listen to your unique needs and provide tailored advice and support. From finding your dream home to navigating the complexities of buying or selling, we’re here to guide you through every step of the process with expertise and care.

                    At Rent Right Services, we believe in making property transactions easier, faster, and more enjoyable. Your satisfaction is our top priority, and we strive to exceed your expectations at every turn. Let us help you make the right move—whether you're starting a new chapter, growing your investment portfolio, or simply finding a better place to call home.
                </p>

            </div>
        </div>

    </section>




    <!-- -----------------our services---------- -->

    <section class="our-services-section">

        <div class="head">
            <h2 class="our-services-title">Our Service</h2>
            <p class="our-services-description">Rent Right Services offers hassle-free, professional property rental solutions, ensuring you find the <br> perfect home or investment with ease and confidence.</p>
        </div>

        <div class="our-services-container">
            <div class="our-services-content">

                <div class="service-item">
                    <div class="service-icon">💰</div>
                    <div class="service-details">
                        <h3 class="service-title">Buying Assistance</h3>
                        <p class="service-description">With Rent Right Services, enjoy expert buying assistance to help you navigate the property market and secure the perfect home or investment with confidence</p>
                    </div>
                </div>

                <div class="service-item">
                    <div class="service-icon">
                        <!-- ⚽ -->
                        <img src="img/icons/sell.png" alt="" srcset="" class="sell">
                    </div>
                    <div class="service-details">
                        <h3 class="service-title">Selling Support</h3>
                        <p class="service-description">Rent Right Services provides comprehensive selling support, guiding you through every step to successfully market and sell your property for the best possible price.</p>
                    </div>
                </div>

                <div class="service-item">
                    <div class="service-icon">↔️</div>
                    <div class="service-details">
                        <h3 class="service-title">Relocation Services</h3>
                        <p class="service-description">Rent Right Services offers seamless relocation support, helping you transition smoothly to your new home with personalized assistance every step of the way.</p>
                    </div>
                </div>
            </div>

            <div class="our-services-image-container">
                <img src="img/icons/service (1).png" alt="Building" class="our-services-image">
            </div>

        </div>
    </section>




    <!-- footer start  -->
    <?php include('footer.php'); ?>

    <script src="js/script.js"></script>
</body>