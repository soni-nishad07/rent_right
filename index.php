<?php
session_start();
include('connection.php');

$is_logged_in = isset($_SESSION['user_id']);


// Fetch distinct bhk_type options
$bhk_query = "SELECT DISTINCT bhk_type FROM category WHERE bhk_type IS NOT NULL";
$bhk_result = $conn->query($bhk_query);

// Fetch distinct price ranges for expected_rent
$price_query = "SELECT DISTINCT expected_rent_from, expected_rent_to FROM category WHERE expected_rent_from IS NOT NULL AND expected_rent_to IS NOT NULL";
$price_result = $conn->query($price_query);
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

    <script>
        function initializeAutocomplete() {
            // Select the input field
            const input = document.getElementById('location-input');
            // Initialize the Autocomplete functionality
            const autocomplete = new google.maps.places.Autocomplete(input);

            // Optionally, restrict to a specific country or types
            // autocomplete.setComponentRestrictions({ country: ["us"] });
            // autocomplete.setTypes(['geocode']);

            // Event listener for when a place is selected
            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                console.log("Selected place:", place);
            });
        }

        // Initialize the Autocomplete on page load
        window.onload = initializeAutocomplete;
    </script>

    <?php include('links.php'); ?>

</head>


<body>

    <?php
    include('head.php');
    ?>

    <header class="header">
        <div class="header-content">
            <h2>Making Home Rentals and Services Easy and Reliable</h2>
            <p>From finding a home to maintaining it, we've got you covered.</p>
        </div>

        <div class="search-bar rent_search_bar">
            <h3>What Do you need?</h3>

            <form action="users/rent_search_property.php" method="POST" class="search-form">
                <input type="text" id="location-input" name="location" placeholder="Enter a location" required />

                <select name="bhk_type" required>
    <option value="" disabled selected>Select BHK Type</option>
    <?php
    if ($bhk_result->num_rows > 0) {
        while ($row = $bhk_result->fetch_assoc()) {
            $bhk_type = htmlspecialchars(trim($row['bhk_type']));
            if (!empty($bhk_type)) { // Skip blank or empty options
                echo "<option value='" . $bhk_type . "'>" . $bhk_type . "</option>";
            }
        }
    }
    ?>
</select>

<select name="expected_rent" required>
    <option value="" disabled selected>Select Expected Rent</option>
    <?php
    if ($price_result->num_rows > 0) {
        while ($row = $price_result->fetch_assoc()) {
            $rent_from = (int)$row['expected_rent_from'];
            $rent_to = (int)$row['expected_rent_to'];

            // Exclude invalid ranges like 0-0
            if ($rent_from > 0 || $rent_to > 0) {
                $price_range = number_format($rent_from) . " - " . number_format($rent_to);
                echo "<option value='" . $price_range . "'>" . $price_range . "</option>";
            }
        }
    }
    ?>
</select>


                <button type="submit" name="search" class="search-button">Search</button>
            </form>

            <!-- Error message display area -->
            <div id="error-message" style="color: red; <?php if (empty($error_message)) echo 'display: none;' ?>">
                <?php echo $error_message; ?>
            </div>
        </div>
    </header>




    <section class="how-it-works">
        <h2>How It Works</h2>
        <div class="agent_steps">
            <div class="agent_step">
                <div class="agents">
                    <img src="./img/icons/icon (1).png" alt="Find a Listing">
                </div>
                <div class="agent_title">
                    <h3>Find a Listing</h3>
                    <p>Make a choice of the type of apartment and qualities that appeal to your interests.</p>
                </div>
            </div>
            <div class="agent_step">
                <div class="agents">
                    <img src="./img/icons/icon (3).png" alt="Talk to an Agent">
                </div>
                <div class="agent_title">
                    <h3>Talk to an Agent</h3>
                    <p>Our agents are available 24 Hours Mon-Sat.</p>
                </div>
            </div>
            <div class="agent_step">
                <div class="agents">
                    <img src="./img/icons/icon (2).png" alt="Move In">
                </div>
                <div class="agent_title">
                    <h3>Set the date and Move In!</h3>
                    <p>Make payments, get receipts, and all other important documents, set your move-in date.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ----------our services------------ -->
    <!-- ----------our services------------ -->



    <div class="services-section1" id="our_service">
        <h2 class="services-title1">Our Services</h2>
        <p class="our-services-description">Rent Right Services offers hassle-free, professional property rental solutions, ensuring you find the <br> perfect home or investment with ease and confidence.</p>
        <div class="container">

            <div class="services-grid1">
                <?php
                $query = "SELECT * FROM services";
                $res = mysqli_query($conn, $query);

                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $service_name = htmlspecialchars($row['service_name']);
                        $image_src = htmlspecialchars($row['service_img']);
                        $service_desc = htmlspecialchars($row['service_description']);
                ?>
                        <div class="service-item1" onclick="openModal('<?php echo $service_name; ?>', '<?php echo $image_src; ?>')">
                            <div class="service_icon1">
                                <img src="uploads/services/<?php echo $image_src; ?>" alt="<?php echo $service_name; ?>" class="service-img">
                            </div>
                            <div class="service_content">
                                <h3 class="service-title1"><?php echo $service_name; ?></h3>
                                <p class="service-description1"><?php echo $service_desc; ?></p>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>

        </div>

    </div>





    <!------------ spotlight----- -->

    <?php
    // $spotlightQuery = "SELECT * FROM properties WHERE property_status = 'Spotlight' LIMIT 1";
    // $result = mysqli_query($conn, $spotlightQuery);

    $spotlightQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Rent', available_for)  AND property_status = 'Spotlight'    AND approval_status = 'Approved' 
                                    LIMIT 1";
    $result = mysqli_query($conn, $spotlightQuery);


    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $images = explode(',', $row['file_upload']);
    ?>
        <section class="spotlight-section">
            <div class="spotlight-header">
                <h2>In <span class="highlight">Spotlight</span></h2>
                <p>Find your best place to live with us.</p>
            </div>

            <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                <div class="spotlight-content">
                    <div class="project-info">
                        <h3><?php echo htmlspecialchars($row['property_type']); ?></h3>
                        <h4><?php echo htmlspecialchars($row['build_up_area']); ?> sqft</h4>
                        <p><?php echo htmlspecialchars($row['city']); ?></p>
                        <!-- <?php
                                $expected_rent = (float)$row[''];
                                $expected_deposit = (float)$row['expected_deposit'];
                                $total = $expected_rent + $expected_deposit;
                                ?> -->
                        <!-- <p class="price-range">₹<?php echo number_format($total, 2); ?></p> -->
                        <p class="price-range">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                        <p class="bhk-info"><?php echo htmlspecialchars($row['bhk_type']); ?></p>
                        <a href="users/property.php" class="contact-btn">View Projects </a>

                    </div>
                    <div class="project-image">
                        <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                            alt="<?php echo htmlspecialchars($row['property_type']); ?>">
                    </div>
                </div>
            </a>
            <div class="thumbnail-carousel">
                <?php foreach ($images as $image) { ?>
                    <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Thumbnail">
                <?php } ?>
            </div>
        </section>

    <?php
    }
    ?>






    <!-- ------Focus projects------- -->
    <?php
    $focusQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Rent', available_for)  AND  property_status = 'Focus'    AND approval_status = 'Approved' LIMIT 2"; // Adjust LIMIT as needed
    $result = mysqli_query($conn, $focusQuery);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
    ?>
        <section class="focus_section">
            <div class="container">
                <div class="spotlight-header">
                    <h2>Projects in <span class="focus_heading">Focus</span></h2>
                    <p>Find your best place to live with us.</p>
                </div>

                <div class="focus_project">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $images = explode(',', $row['file_upload']);
                        $user_id = $row['user_id']; // Adjust this field name as necessary
                        $userQuery = "SELECT * FROM customer_register WHERE id = '$user_id'";
                        $userResult = mysqli_query($conn, $userQuery);

                        if ($userResult && mysqli_num_rows($userResult) > 0) {
                            $userData = mysqli_fetch_assoc($userResult);
                            $userName = htmlspecialchars($userData['name']);
                        } else {
                            $userName = 'Unknown';
                        }
                        // $expected_rent = (float)$row['expected_rent'];
                        // $expected_deposit = (float)$row['expected_deposit'];
                        // $total = $expected_rent + $expected_deposit;
                    ?>

                        <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                            <div class="card-top">
                                <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                                    alt="<?php echo htmlspecialchars($row['property_type']); ?>">
                                <div class="card-top-content">
                                    <h2><?php echo htmlspecialchars($row['property_type']); ?></h2>
                                    <!-- <h3>by <?php echo $userName; ?></h3> -->
                                    <p><?php echo htmlspecialchars($row['bhk_type']); ?>
                                        Apartments<br><?php echo htmlspecialchars($row['city']); ?></p>
                                    <p class="price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php
    } else {
        echo '<!-- No Focus properties available at the moment. -->';
    }
    ?>





    <!-- Rental img -->


    <?php
    // Query to fetch trending properties

    // $trendingQuery = "SELECT * FROM properties  ORDER BY id DESC "; 
    $trendingQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Rent', available_for)  AND  approval_status = 'Approved' ORDER BY id DESC  LIMIT 6";
    $trendingResult = mysqli_query($conn, $trendingQuery);
    if ($trendingResult && mysqli_num_rows($trendingResult) > 0) {
        $count = 0; // Initialize a counter
    ?>
        <section class="trending">
            <div class="container">
                <h2 class="title-trending">Rental Project in <span>Bengaluru</span></h2>
                <p class="subtitle-trending">All Projects in Bengaluru</p>
                <div class="grid">
                    <?php
                    while ($row = mysqli_fetch_assoc($trendingResult)) {
                        if ($count >= 4) break; // Display only the first 4 cards

                        $images = explode(',', $row['file_upload']);
                        $user_id = $row['user_id']; // Adjust this field name as necessary
                        $userQuery = "SELECT * FROM customer_register WHERE id = '$user_id'";
                        $userResult = mysqli_query($conn, $userQuery);

                        if ($userResult && mysqli_num_rows($userResult) > 0) {
                            $userData = mysqli_fetch_assoc($userResult);
                        } else {
                            $userName = 'Unknown';
                        }
                    ?>
                        <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                            <div class="card-project">
                                <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                                    alt="<?php echo htmlspecialchars($row['property_type']); ?>" class="card-project-img">
                                <div class="card-project-content">
                                    <h3 class="card-project-title-trending"><?php echo htmlspecialchars($row['property_type']); ?></h3>
                                    <!-- <p class="card-project-company">by <?php echo $userName; ?></p> -->
                                    <p class="card-project-description"><?php echo htmlspecialchars($row['bhk_type']); ?>
                                        Apartments<br><?php echo htmlspecialchars($row['city']); ?></p>
                                    <p class="card-project-price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                                </div>
                            </div>
                        </a>
                    <?php
                        $count++; // Increment counter
                    }
                    ?>
                </div>

                <!-- Show the "View More" button if there are more than 4 properties -->
                <?php if (mysqli_num_rows($trendingResult) > 4): ?>
                    <div class="view-more-container" style="text-align:center; margin-top: 20px;color:white;">
                        <a href="users/property.php" class="view-more-btn">View More</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php
    } else {
        echo  '<!-- <p style="text-align:center;">No Rental properties available at the moment.</p>  -->';
    }
    ?>




    <!-- ------Sale & Commercial projects------- -->
    <?php
    $focusQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Rent', available_for)  AND  property_status = 'Sale & Commercial'  AND approval_status = 'Approved'  LIMIT 2"; // Adjust LIMIT as needed
    $result = mysqli_query($conn, $focusQuery);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
    ?>
        <section class="focus_section">
            <div class="container">
                <div class="spotlight-header">
                    <h2>Projects in <span class="focus_heading">Sale & Commercial</span></h2>
                    <p>Find your best place to live with us.</p>
                </div>

                <div class="focus_project">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $images = explode(',', $row['file_upload']);
                        $user_id = $row['user_id']; // Adjust this field name as necessary
                        $userQuery = "SELECT * FROM customer_register WHERE id = '$user_id'";
                        $userResult = mysqli_query($conn, $userQuery);

                        if ($userResult && mysqli_num_rows($userResult) > 0) {
                            $userData = mysqli_fetch_assoc($userResult);
                            $userName = htmlspecialchars($userData['name']);
                        } else {
                            $userName = 'Unknown';
                        }
                        // $expected_rent = (float)$row['expected_rent'];
                        // $expected_deposit = (float)$row['expected_deposit'];
                        // $total = $expected_rent + $expected_deposit;
                    ?>

                        <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                            <div class="card-top">
                                <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                                    alt="<?php echo htmlspecialchars($row['property_type']); ?>">
                                <div class="card-top-content">
                                    <h2><?php echo htmlspecialchars($row['property_type']); ?></h2>
                                    <!-- <h3>by <?php echo $userName; ?></h3> -->
                                    <p><?php echo htmlspecialchars($row['bhk_type']); ?>
                                        Apartments<br />
                                        <?php echo htmlspecialchars($row['city']); ?></p>
                                    <p class="price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php
    } else {
        echo '<!-- No Sale & Commercial properties available at the moment. -->';
    }
    ?>







    <!-- Trending Section -->
    <!-- // Query to fetch properties available for rent -->

    <?php
    $rentQuery = "SELECT * FROM properties WHERE FIND_IN_SET('Rent', available_for) AND property_status = 'Trending'    AND approval_status = 'Approved' LIMIT 6";
    $rentResult = mysqli_query($conn, $rentQuery);
    // 
    ?>

    <?php if ($rentResult && mysqli_num_rows($rentResult) > 0) { ?>
        <section class="trending">
            <div class="container">
                <h2 class="title-trending">Trending <span>Projects</span></h2>
                <p class="subtitle-trending">Properties for Rent</p>

                <!-- Rent Properties Section -->
                <!-- <h4 class="subtitle-category">Properties for Rent</h4> -->
                <div class="grid">
                    <?php
                    while ($row = mysqli_fetch_assoc($rentResult)) {
                        $images = explode(',', $row['file_upload']);
                    ?>
                        <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                            <div class="card-project">
                                <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                                    alt="<?php echo htmlspecialchars($row['property_type']); ?>" class="card-project-img">
                                <div class="card-project-content">
                                    <h3 class="card-project-title-trending">
                                        <?php echo htmlspecialchars($row['property_type']); ?>
                                    </h3>
                                    <p class="card-project-description">
                                        <?php echo htmlspecialchars($row['bhk_type']); ?> Apartments<br>
                                        <?php echo htmlspecialchars($row['city']); ?>
                                    </p>
                                    <p class="card-project-price">
                                        ₹<?php echo htmlspecialchars($row['expected_rent']); ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>



    <!------------------- Featured----------- -->


    <?php
    // Query to fetch 'Featured' properties
    // $featuredQuery = "SELECT * FROM properties WHERE property_status = 'Featured' LIMIT 6";
    $featuredQuery = "SELECT * FROM properties WHERE FIND_IN_SET('Rent', available_for)  AND property_status = 'Featured'    AND approval_status = 'Approved'  LIMIT 6";
    // Adjust LIMIT as needed
    $result = mysqli_query($conn, $featuredQuery);
    $hasProperties = false;
    // Flag to check if there are properties

    if ($result && mysqli_num_rows($result) > 0) {
        $hasProperties = true;
        // Set flag to true if there are properties
    ?>

        <section class="featured-collections">
            <div class="container">
                <h2 class="section-title">Featured <span>Projects</span></h2>
                <p class="section-subtitle">Handpicked projects for you</p>
                <div class="slider-wrapper">
                    <div class="collections-grid">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $images = explode(',', $row['file_upload']);
                            $imageSrc = htmlspecialchars($images[0]);
                            $title = htmlspecialchars($row['property_type']);
                            $description = htmlspecialchars($row['description']);
                        ?>
                            <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                                <div class="collection-card">
                                    <img src="uploads/<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>">
                                    <div class="overlay2">
                                        <h3><?php echo $title; ?></h3>
                                        <p><?php echo $description; ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <?php if ($hasProperties) { // Show arrows only if there are properties 
                ?>
                    <div class="arrows">
                        <button class="arrow-btn left">&#10094;</button>
                        <button class="arrow-btn right">&#10095;</button>
                    </div>
                <?php } // End of arrows display condition 
                ?>
            </div>
        </section>

    <?php
    }
    ?>




    <!-- Modal for Booking Form -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h1 class="booking_for">Schedule a visit: <span id="modalTitle"></span></h1>
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
                <!-- <div class="input-group">
                    <input type="date" id="booking_date" name="booking_date" required>
                </div> -->
                <div class="input-group">
                    <!-- <span>Provide Date For Booking!</span> -->
                </div>
                <!-- <button type="submit" name="book-visit" class="book-visit">Schedule a Visit</button> -->
                <button type="submit" name="book-services"  class="book-visit">Schedule a Visit</button>
            </form>
        </div>
    </div>

    <script>
        // Modal handling
        function openModal(serviceName, imageSrc) {
            document.getElementById("modalTitle").innerText = serviceName;
            document.getElementById("service_name").value = serviceName;
            document.getElementById("myModal").style.display = "block";
            document.getElementById("booking_id").value = generateBookingID();
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("myModal")) {
                closeModal();
            }
        }

        // Form validation
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var mobile = document.getElementById("mobile").value;
            // var date = document.getElementById("booking_date").value;

            if (name === "" || email === "" || mobile === "") {
                alert("All fields must be filled out");
                return false;
            }

            var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
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







    <!-- footer start  -->
    <?php include('footer.php'); ?>

    <script src="js/script.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- ---------------- Spotlight ------------------------>
    <script>
        document.querySelectorAll('.thumbnail-carousel img').forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', function() {
                const mainImage = document.querySelector('.project-image img');
                mainImage.src = this.src;
                // Set the main image to the clicked thumbnail
            });
        });
        const sliderWrapper = document.querySelector('.slider-wrapper');
        const collectionsGrid = document.querySelector('.collections-grid');
        const leftArrow = document.querySelector('.arrow-btn.left');
        const rightArrow = document.querySelector('.arrow-btn.right');
        let currentIndex = 0;
        const cardWidth = 320;
        // Adjust based on the card's width + margin
        function updateSliderPosition() {
            const newTransformValue = `translateX(-${currentIndex * cardWidth}px)`;
            collectionsGrid.style.transform = newTransformValue;
        }
        rightArrow.addEventListener('click', () => {
            const maxIndex = collectionsGrid.children.length - 3;
            // 3 items visible at a time
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSliderPosition();
            }
        });
        leftArrow.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSliderPosition();
            }
        });
    </script>




    <!-- // JavaScript to hide the error message after a few seconds  search result-->
    <script>
        $(document).ready(function() {
            if ($('#error-message').text().trim() !== '') {
                setTimeout(function() {
                    $('#error-message').fadeOut('slow');
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>



</body>

</html>