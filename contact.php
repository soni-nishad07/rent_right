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
        <h2 class="brdcrum">Contact us</h2>
    </header>





    <section class="contact-section">
        <div class="container">
            <h2>Get In Touch With Us & Send Us Messages</h2>
            <div class="contact-container">

                <!-- <form class="contact-form"  action="https://formsubmit.co/"  method="POST" onsubmit="showSuccessMessage(event)"> -->

                <form class="contact-form" action="save_contact.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="text" name="mobile" placeholder="Mobile number" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <!-- <input type="hidden" name="_captcha" value="false"> -->
                    <!-- <input type="hidden" name="_template" value="table"> -->
                    <button type="submit">Send Message</button>
                </form>
                
                <div class="contact-info">
                    <p><strong>Address</strong></p>
                    <p>
                        <a href="tel:+919538865407">
                            <i class="fas fa-phone"></i> +91-9538865407
                        </a>
                    </p>

                    <!-- <p><a  href="mailto:" >
                    <i class="fas fa-envelope"></i> abc@gmail.com
                     </a></p>  -->

                    <p><i class="fas fa-map-marker-alt"></i> No.138, 20th Main Road,
                        7th Cross, BTM 2nd Stage, <br>
                        <span style="padding-left :25px">
                            Bangalore, 560076.
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- footer start  -->
    <?php include('footer.php'); ?>

    <script src="js/script.js"></script>

</body>