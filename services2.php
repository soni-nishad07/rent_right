<?php
session_start();
include('connection.php');

$is_logged_in = isset($_SESSION['user_id']); // Adjust this condition based on your actual session variable for logged-in users
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Right Bangalore</title>
    <link rel="shortcut icon" href="admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/services.css">  -->
    <script src="js/bootstrap.bundle.js" defer></script>
    <script src="js/script.js" defer></script>
    <?php
    include('head.php');
    ?>
    <style>
        main {
            padding: 10px 10px;
            text-align: center;
        }

        .service {
            margin-top: 60px;
            font-size: 30px;
        }

        .services-grid {
            display: block;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 60px;
            padding-bottom: 60px;
            outline: none;
        }

        .service-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            transition: transform 0.2s;
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .service-card img {

            width: 55px;
            /* margin-bottom: 10px; */
            align-items: center;
        }

        .service-name {
            font-size: 10px;
            font-weight: bold;
            /* margin-left: 250px; */
        }

        @media (max-width: 500px) {
            .header {
                flex-direction: column;
            }

            .search-bar input {
                width: 100%;
                margin: 10px 0;
            }

            .menu a,
            .login-btn {
                margin: 10px 0;
            }

            .services-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }
        }

        /* ------------------------------ */
        /* Modal CSS */
        .modal {
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            /* padding: 20px 40px; */
            padding: 20px 40px 60px 40px;
            border: 1px solid #888;
            width: 50% !important;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            text-align: right;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Additional styles for the main body */
        body {
            font-family: Arial, sans-serif;
        }


        /* ---------------------------- */

        .service_logos {
            height: 50px !important;
            width: 100px !important;
        }


        .service-card {
            text-align: center;
            cursor: pointer;
        }

        .service-card img {
            max-width: 100%;
            height: auto;
        }

        #modalTitle {
            color: #ff6f6f;
        }

        h1.booking_for {
            text-align: center;
            font-size: 25px;
            font-weight: 600;
        }

        form#bookingForm {
            margin: 40px 20px;
        }


        /* Styles for the booking form */
        .input-group {
            margin-bottom: 15px;
        }

        /* #bookingForm input,
        #bookingForm textarea,
        #bookingForm select option {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        } */
        #bookingForm input, #bookingForm textarea, #bookingForm select option {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    color: black !important;
    border-radius: 4px;
}

        button.book-services {
            margin-top: 15px;
        }

        span.Provide-date {
            margin-top: 20px;
        }

        button {
            background-color: #ff4d4d;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #ff3333;
        }


        /* Responsive Styles */
        @media (max-width: 1200px) {
            .services-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .service {
                font-size: 1.5rem;
            }

            .modal-content {
                width: 70% !important;
            }
        }

        @media (max-width: 768px) {
            .service {
                font-size: 1.2rem;
            }

            .services-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }

            .header {
                flex-direction: column;
            }

            .search-bar input {
                width: 100%;
                margin: 10px 0;
            }

            .menu a,
            .login-btn {
                margin: 10px 0;
            }
        }

        @media (max-width: 500px) {
            .service {
                font-size: 1rem;
            }

            .modal-content {
                width: 95% !important;
                padding: 15px;
            }

            .input-group {
                margin-bottom: 10px;
            }

            button {
                padding: 12px;
            }

            .row-cols-5>* {
                flex: 0 0 auto;
                width: 100%;
            }

            .service-card img {
                max-width: 100%;
                height: auto;
            }

            .service-card img {
                width: 35%;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <main>
        <h1 class="service">Complete Home Service Solutions</h1>
        <p>"Making your home move-in ready with professional care."</p>

        <div class="container text-center">
            <div class="services-grid">
                <div class="row row-cols-5">
                    <?php
                    $query = "SELECT * FROM services";
                    $res = mysqli_query($conn, $query);

                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $service_name = htmlspecialchars($row['service_name']);
                            $image_src = htmlspecialchars($row['service_img']);
                    ?>
                    <div class="col">
                        <div class="service-card" onclick="openModal('<?php echo $service_name; ?>')">
                            <img src="uploads/services/<?php echo $image_src; ?>" alt="<?php echo $service_name; ?>"
                                class="service-img">
                            <div class="service-name"><?php echo $service_name; ?></div>
                        </div>
                    </div>
                    <?php
                        }
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for Booking Form -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h1 class="booking_for">Booking for: <span id="modalTitle"></span></h1>
            <form id="bookingForm" action="service-insert.php" method="POST" onsubmit="return validateForm()">
                <input type="hidden" id="booking_id" name="booking_id" value="">
                <input type="hidden" id="service_name" name="service_name" value="">
                <input type="hidden" id="booking_status" name="booking_status" value="pending">

                <div class="input-group">
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="number" id="mobile" name="mobile" placeholder="Mobile Number" required>
                </div>
                <div class="input-group">
                    <textarea name="address" rows="3" cols="100" id="address" placeholder="Enter Address"
                        required></textarea>
                </div>
                <div class="input-group">
                    <select class="form-select" aria-label="Default select" id="payment_mode" name="payment_mode"
                        required>
                        <option value="" disabled selected>----Select Payment Mode---</option>
                        <option value="cash">Cash</option>
                        <!-- Add more payment options here if needed -->
                    </select>
                </div>
                <div class="input-group">
                    <input type="date" id="booking_date" name="booking_date" required>
                </div>
                <div class="input-group">
                    <span>Provide Date For Booking!</span>
                </div>
                <!-- <button type="submit" name="book-services" class="book-services">Book Now</button> -->
                <button type="submit" name="book-visit" class="book-visit">Book Now</button>
            </form>
        </div>
    </div>

    <?php include('copyright.php'); ?>

    <script>
        // Modal handling
        function openModal(serviceName) {
            document.getElementById("modalTitle").innerText = serviceName;
            document.getElementById("service_name").value = serviceName; // Set the service name in the hidden field
            document.getElementById("myModal").style.display = "block";
            // Generate unique booking ID
            document.getElementById("booking_id").value = generateBookingID();
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const service = urlParams.get('service');
            if (service) {
                openModal(decodeURIComponent(service));
            }
        }
        // Form validation
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var mobile = document.getElementById("mobile").value;
            var address = document.getElementById("address").value;
            var paymentMode = document.getElementById("payment_mode").value;
            var date = document.getElementById("booking_date").value;
            if (!name || !email || !mobile || !address || !paymentMode || !date) {
                alert("All fields must be filled out");
                return false;
            }
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,3}$/;
            if (!email.match(emailPattern)) {
                alert("Please enter a valid email address");
                return false;
            }
            var mobilePattern = /^[0-9]{10}$/;
            if (!mobile.match(mobilePattern)) {
                alert("Please enter a valid 10-digit mobile number");
                return false;
            }
            return true;
        }
        // Function to generate unique booking ID
        function generateBookingID() {
            return 'booking_' + Date.now();
        }
    </script>
</body>

</html>