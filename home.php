<?php
session_start();
include('connection.php');

$is_logged_in = isset($_SESSION['user_id']);


// Fetch distinct property types and deposit ranges for filtering
$property_type_query = "SELECT DISTINCT property_type FROM category   WHERE property_choose LIKE '%Buy%' ";
$property_type_result = $conn->query($property_type_query);

// Fetch distinct price ranges for expected deposit
$deposit_query = "SELECT DISTINCT expected_deposit_from, expected_deposit_to FROM category WHERE expected_deposit_from IS NOT NULL AND expected_deposit_to IS NOT NULL";
$deposit_result = $conn->query($deposit_query);


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

    <header class="header" style="background: url('img/home2.png') center/cover no-repeat;">

        <div class="header-content">
            <h2>From Searching to Owning – Make It Yours Now</h2>
            <p>Your Trusted Partner in Property Ownership!</p>
            <a href="contact">
                <button class="home_contact-button">Contact Us</button>
            </a>
        </div>

        <div class="search-bar rent_search_bar">
            <h3>What Do you need?</h3>
            <div class="search-options">
                <button class="search-option">Location</button>
                <button class="search-option ">Category</button>
                <button class="search-option">Budget</button>
            </div>

            <!-- <form action="users/search_property.php" method="POST" class="search-form"> -->
                        <form action="users/buy_search_property.php" method="POST" class="search-form">
                <input type="text" id="location-input" name="location" placeholder="Enter a location" required />
                <select name="	property_type" required>
                    <option value="">Property Type</option>
                    <?php
                    if ($property_type_result->num_rows > 0) {
                        while ($row = $property_type_result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['property_type']) . "'>" . htmlspecialchars($row['property_type']) . "</option>";
                        }
                    }
                    ?>
                </select>
                
                <!-- Expected Deposit Dropdown -->
                            <select name="expected_deposit" required>
                <option value="" disabled selected>Select Expected Price</option>
                <?php
                if ($deposit_result->num_rows > 0) {
                    while ($row = $deposit_result->fetch_assoc()) {
                        $deposit_from = (int)$row['expected_deposit_from'];
                        $deposit_to = (int)$row['expected_deposit_to'];

                        // Exclude invalid ranges like 0-0
                        if ($deposit_from > 0 || $deposit_to > 0) {
                            $deposit_range = number_format($deposit_from) . " - " . number_format($deposit_to);
                            echo "<option value='" . $deposit_range . "'>" . $deposit_range . "</option>";
                        }
                    }
                }
                ?>
            </select>

                <button type="submit" name="search" class="search-button">Search</button>
            </form>
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





    <section class="become_host">
        <div class="container">
            <div class="banner">
                <div class="bnner_overlay">
                    <div class="banner_content">
                        <h1>Become a Host</h1>
                        <p>Join thousands of Landlords <br> and earn an extra income.</p>
                        <a href="users/property">
                            <button>Learn More</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- ----------------------property based on selected------------------- -->



    <!------------ spotlight----- -->

    <?php
    // $spotlightQuery = "SELECT * FROM properties WHERE property_status = 'Spotlight' LIMIT 1";
    $spotlightQuery = "SELECT * FROM properties WHERE FIND_IN_SET('Sale', available_for)  AND property_status = 'Spotlight'    AND approval_status = 'Approved' 
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
    $focusQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Sale', available_for)  AND  property_status = 'Focus'    AND approval_status = 'Approved' 
    LIMIT 2";
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
    <!-- // Query to fetch trending properties -->
    <?php
    $trendingQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Sale', available_for)  AND  approval_status = 'Approved' ORDER BY id DESC LIMIT 6";
    $trendingResult = mysqli_query($conn, $trendingQuery);
    if ($trendingResult && mysqli_num_rows($trendingResult) > 0) {
        $count = 0; // Initialize a counter
    ?>
        <section class="trending">
            <div class="container">
                <h3 class="title-trending">Sale Project in <span>Bengaluru</span></h3>
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
    $focusQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Sale', available_for)  AND  property_status = 'Sale & Commercial'    AND approval_status = 'Approved' LIMIT 2";
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




    <!-- -------------Trending projects----- -->

    <?php
    // $saleQuery = "SELECT * FROM properties WHERE FIND_IN_SET('Sale', available_for) AND property_status = 'Trending' LIMIT 6";
    $saleQuery = " SELECT * FROM properties 
              WHERE FIND_IN_SET('Sale', available_for) 
              AND property_status = 'Trending' 
              AND approval_status = 'Approved' 
              LIMIT 6";
    $saleResult = mysqli_query($conn, $saleQuery);
    // 
    ?>

    <?php if ($saleResult && mysqli_num_rows($saleResult) > 0) { ?>
        <section class="trending">
            <div class="container">
                <h2 class="title-trending">Trending <span>Projects</span></h2>
                <p class="subtitle-trending">Properties for Sale</p>

                <!-- Rent Properties Section -->
                <!-- <h4 class="subtitle-category">Properties for Rent</h4> -->
                <div class="grid">
                    <?php
                    while ($row = mysqli_fetch_assoc($saleResult)) {
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
    $featuredQuery = "SELECT * FROM properties  WHERE FIND_IN_SET('Sale', available_for)  AND  property_status = 'Featured'    AND approval_status = 'Approved'  LIMIT 6"; // Adjust LIMIT as needed
    $result = mysqli_query($conn, $featuredQuery);
    $hasProperties = false; // Flag to check if there are properties

    if ($result && mysqli_num_rows($result) > 0) {
        $hasProperties = true; // Set flag to true if there are properties
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


    <!-- featured collections end -->






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
                <div class="input-group">
                    <input type="date" id="booking_date" name="booking_date" required>
                </div>
                <div class="input-group">
                    <!-- <span>Provide Date For Booking!</span> -->
                </div>
                <button type="submit" name="book-visit" class="book-visit">Schedule a Visit</button>
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
            var date = document.getElementById("booking_date").value;

            if (name === "" || email === "" || mobile === "" || date === "") {
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

    <!-- spotlight -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.querySelectorAll('.thumbnail-carousel img').forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', function() {
                const mainImage = document.querySelector('.project-image img');
                mainImage.src = this.src; // Set the main image to the clicked thumbnail
            });
        });
        const sliderWrapper = document.querySelector('.slider-wrapper');
        const collectionsGrid = document.querySelector('.collections-grid');
        const leftArrow = document.querySelector('.arrow-btn.left');
        const rightArrow = document.querySelector('.arrow-btn.right');
        let currentIndex = 0;
        const cardWidth = 320; // Adjust based on the card's width + margin
        function updateSliderPosition() {
            const newTransformValue = `translateX(-${currentIndex * cardWidth}px)`;
            collectionsGrid.style.transform = newTransformValue;
        }
        rightArrow.addEventListener('click', () => {
            const maxIndex = collectionsGrid.children.length - 3; // 3 items visible at a time
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



</body>

</html>