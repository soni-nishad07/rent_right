<?php
include('../connection.php');
include('session_check.php');

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">

    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places">
    </script>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <?php
        include('../links.php');
    ?>

</head>

<body>

    <div class="container-fluid hero-section">


    <header>
        <div class="container">
            <div class="row">

                <div class="logo">
                    <a href="../index">
                        <img src="../icons/Logo.png" alt="Rent Right Bangalore">
                    </a>
                </div>

                <div class="search-bar">
                    <input type="search" id="searchInput" placeholder="Search" onkeyup="checkEnter(event)">
                    <div class="explore-dropdown" onclick="toggleDropdown()">Explore▼</div>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <?php
                        $query = "SELECT * FROM dropdown_values";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $link = '';
                                switch ($row['value']) {
                                    case 'Rent':
                                        $link = '../index.php';
                                        break;
                                    case 'Sale':
                                        $link = '../home2.php';
                                        break;
                                    case 'Commercial':
                                        $link = '../home3.php';
                                        break;
                                    default:
                                        $link = '../services2.php?service=' . urlencode($row['value']);
                                        break;
                                }
                                echo '<a href="' . $link . '">' . htmlspecialchars($row['value']) . '</a>';
                            }
                        } else {
                            echo '<a href="#">No services available</a>';
                        }
                        ?>
                        <a href="../services2.php" style="color: #ff594e;">See All</a>
                    </div>
                </div>

                 <nav class="menu">
                    <a href="property">Post Free Property</a>
                </nav> 




                <div class="login-header">
                    <?php if(isset($_SESSION['user_name'])): ?>
                    <div class="dropdown">
                        <a class="btn  dropdown-toggle" href="#" role="button" id="secondaryDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['user_name']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="secondaryDropdown">
                            <li><a class="dropdown-item" href="user-dashboard">Home</a></li>
                            <li><a class="dropdown-item" href="enquiries"> Requests received</a></li>
                            <li><a class="dropdown-item" href="saved"> Saved</a></li>
                            <li><a class="dropdown-item" href="Property_list"> Property Listing</a></li>
                            <li><a class="dropdown-item" href="Property_all_list"> All Property Listing</a></li>
                            <li><a class="dropdown-item" href="UserProfile">Update Profile</a></li>
                            <li><a class="dropdown-item" href="chngepswd">Change Password </a></li>
                            <li><a class="dropdown-item" href="../logout">Logout</a></li>
                        </ul>
                    </div>
                    <?php else: ?>
                        <a href="../login">
                    <nav class="login-btn">
                            Login / Sign Up
                    </nav>
                            </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <h1>Making Home Rentals and Services<br>Easy and Reliable</h1>
            <p>"From finding a home to maintaining it, we've got you covered."</p>
            <div class="container hero1-home">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-lg-10 col-md-10 offset-lg-1">
                        <div class="dropdown">
                            <select id="bhk-type">
                                <option value="">BHK Type</option>
                                <option value="1BHK" class="bhk">1 BHK</option>
                                <option value="2BHK" class="bhk">2 BHK</option>
                                <option value="3BHK" class="bhk">3 BHK</option>
                                <option value="4BHK" class="bhk">4 BHK</option>
                                <option value="5BHK" class="bhk">5 BHK</option>
                                <option value="IndependentHouse">Independent House</option>
                            </select>
                            <button class="button active rent-btn"
                                onclick="validateAndProceed('../index', 'Rent')">Rent</button>
                            <button class="button btn-bhk"
                                onclick="validateAndProceed('../home2', 'Sale')">Sale</button>
                            <button class="button btn-bhk"
                                onclick="validateAndProceed('../home3', 'Commercial')">Commercial</button>
                        </div>

                        <div class="checkboxes">
                            <label><input type="checkbox" id="unfurnished"> Unfurnished</label>
                            <label><input type="checkbox" id="semi-furnished"> Semi-Furnished</label>
                            <label><input type="checkbox" id="fully-furnished" checked> Fully-Furnished</label>
                        </div>
                    </div>
                </div>
            </div>

            <section>
                <div class="search-container">
                    <div class="search-box">
                        <input id="location-input" type="search" placeholder="Type Your Location">
                    </div>
                    <button class="search-button" onclick="validateSearch()">Search</button>
                </div>
                <div id="search-results"></div>
            </section>
        </section>
    </main>

</div>
        
    <!-- Error Message Container -->
    <div id="error-message" style="color: red; text-align: center; margin-top: 20px; display: none;"></div>

    <!------------ spotlight----- -->

    <?php
    $spotlightQuery = "SELECT * FROM properties WHERE property_status = 'Spotlight' LIMIT 1";
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
                <a href="property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">

        <div class="spotlight-content">
            <div class="project-info">
                <h3><?php echo htmlspecialchars($row['property_type']); ?></h3>
                <h4><?php echo htmlspecialchars($row['build_up_area']); ?> sqft</h4>
                <p><?php echo htmlspecialchars($row['city']); ?></p>
                <?php
                $expected_rent = (float)$row['expected_rent'];
                $expected_deposit = (float)$row['expected_deposit'];
                $total = $expected_rent + $expected_deposit;
                ?>
                <p class="price-range">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                <p class="bhk-info"><?php echo htmlspecialchars($row['bhk_type']); ?></p>
                <a href="property.php" class="contact-btn">View Projects
                </a>
            </div>
            <div class="project-image">
                <img src="../uploads/<?php echo htmlspecialchars($images[0]); ?>"
                    alt="<?php echo htmlspecialchars($row['property_type']); ?>">
            </div>
        </div>
        </a>
        <div class="thumbnail-carousel">
            <?php foreach ($images as $image) { ?>
            <img src="../uploads/<?php echo htmlspecialchars($image); ?>" alt="Thumbnail">
            <?php } ?>
        </div>
    </section>
    <?php
}
?>







    <!-- ------Focus projects------- -->
    <?php
$focusQuery = "SELECT * FROM properties WHERE property_status = 'Focus' LIMIT 2"; // Adjust LIMIT as needed
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

                    $expected_rent = (float)$row['expected_rent'];
                    $expected_deposit = (float)$row['expected_deposit'];
                    $total = $expected_rent + $expected_deposit;
                ?>
                            <a href="property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">

                <div class="card-top">
                    <img src="../uploads/<?php echo htmlspecialchars($images[0]); ?>"
                        alt="<?php echo htmlspecialchars($row['property_type']); ?>">
                    <div class="card-top-content">
                        <h2><?php echo htmlspecialchars($row['property_type']); ?></h2>
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
    // Optionally, you can also include a message or section when no properties are found
    echo '<!-- No Focus properties available at the moment. -->';
}
?>











<!-- Rental img -->


<?php
// Query to fetch trending properties
$trendingQuery = "SELECT * FROM properties  WHERE approval_status = 'Approved' ORDER BY id DESC "; // Adjust query as needed
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
                    <img src="../uploads/<?php echo htmlspecialchars($images[0]); ?>"
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











    <!-- -------------Trending projects----- -->

    <?php
      // Query to fetch trending properties
      $trendingQuery = "SELECT * FROM properties WHERE property_status = 'Trending' LIMIT 6"; // Adjust LIMIT as needed
      $trendingResult = mysqli_query($conn, $trendingQuery);
      if ($trendingResult && mysqli_num_rows($trendingResult) > 0) {

  ?>
    <section class="trending">
        <div class="container">
            <h2 class="title-trending">Trending <span>Projects</span></h2>
            <p class="subtitle-trending">Most sought-after projects in Lucknow</p>
            <div class="grid">
                <?php
              while ($row = mysqli_fetch_assoc($trendingResult)) {

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

                    $expected_rent = (float)$row['expected_rent'];
                    $expected_deposit = (float)$row['expected_deposit'];
                    $total = $expected_rent + $expected_deposit;
            ?>
                                        <a href="property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                <div class="card-project">
                    <img src="../uploads/<?php echo htmlspecialchars($images[0]); ?>"
                        alt="<?php echo htmlspecialchars($row['property_type']); ?>" class="card-project-img">
                    <div class="card-project-content">
                        <h3 class="card-project-title-trending"><?php echo htmlspecialchars($row['property_type']); ?>
                        </h3>
                  
                        <p class="card-project-description"><?php echo htmlspecialchars($row['bhk_type']); ?>
                            Apartments<br><?php echo htmlspecialchars($row['city']); ?></p>
                        <p class="card-project-price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                    </div>
                </div>
                </a>
                <?php
                }
            } else {
                echo  '<!-- <p style="text-align:center;">No Trending properties available at the moment.</p>  -->';
            }
            ?>
            </div>
        </div>
    </section>

    <!------------------- Featured----------- -->

<?php
// Query to fetch 'Featured' properties
$featuredQuery = "SELECT * FROM properties WHERE property_status = 'Featured' LIMIT 6"; // Adjust LIMIT as needed
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
                                            <a href="property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">

                <div class="collection-card">
                    <img src="../uploads/<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>">
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

        <?php if ($hasProperties) { // Show arrows only if there are properties ?>
        <div class="arrows">
            <button class="arrow-btn left">&#10094;</button>
            <button class="arrow-btn right">&#10095;</button>
        </div>
        <?php } // End of arrows display condition ?>
    </div>
</section>

<?php
}
?>

  
  
  
  
  

    <!-- footer start  -->

    <!-- footer start  -->
    <?php include('../footer.php'); ?>

    <script src="../js/script.js"></script>

    <!-- ---------location search- -->
    <script>
        $(document).ready(function() {
            var input = document.getElementById('location-input');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    showErrorMessage("No details available for input: '" + place.name + "'");
                    return;
                }
                // You can use the place object to get details about the selected place
                console.log(place);
            });
        });
        //------------------------------------Index 1----------------------------
        function validateSearch() {
            var locationInput = document.getElementById('location-input').value;
            if (locationInput === "") {
                showErrorMessage("Please enter a location to search.");
            } else {
                performSearch(locationInput);
            }
        }

        function validateAndProceed(targetPage, actionType) {
            var bhkType = document.getElementById('bhk-type').value;
            var locationInput = document.getElementById('location-input').value;
            if (actionType === 'Rent') {
                if (!bhkType) {
                    showErrorMessage("Please select a BHK type.");
                    return;
                } else if (!locationInput) {
                    showErrorMessage("Please enter a location.");
                    return;
                }
            }
            window.location.href = targetPage;
        }

        function performSearch(location) {
            var bhkType = document.getElementById('bhk-type').value;
            var unfurnished = document.getElementById('unfurnished').checked;
            var semiFurnished = document.getElementById('semi-furnished').checked;
            var fullyFurnished = document.getElementById('fully-furnished').checked;
            $.ajax({
                url: 'check_properties.php',
                method: 'GET',
                data: {
                    location: location,
                    bhkType: bhkType,
                    unfurnished: unfurnished,
                    semiFurnished: semiFurnished,
                    fullyFurnished: fullyFurnished
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.hasProperties) {
                        window.location.href = 'property.php';
                    } else {
                        showErrorMessage('No properties matched your search.');
                    }
                },
                error: function(error) {
                    console.error(error);
                    showErrorMessage('An error occurred while searching for properties.');
                }
            });
        }

        function showErrorMessage(message) {
            var errorMessageContainer = document.getElementById('error-message');
            errorMessageContainer.textContent = message;
            errorMessageContainer.style.display = 'block';
            setTimeout(function() {
                errorMessageContainer.style.display = 'none';
            }, 3000);
        }
    </script>


    <!-- ------------dropdown---------- -->
    <script>
        function toggleDropdown() {
            var dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        }

        function checkEnter(event) {
            if (event.key === 'Enter') {
                const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
                switch (searchInput) {
                    case 'rent':
                        window.location.href = '../index.php';
                        break;
                    case 'sale':
                        window.location.href = '../home2.php';
                        break;
                    case 'commercial':
                        window.location.href = '../home3.php';
                        break;
                    case 'movers & packers':
                    case 'movers':
                    case 'packers':
                        window.location.href = '../services2.php?service=' + encodeURIComponent('Movers & Packers');
                        break;
                    case 'electrician':
                    case 'plumbing':
                    case 'cleaning services':
                    case 'interiors':
                    case 'exteriors':
                        window.location.href = '../services2.php?service=' + encodeURIComponent(searchInput);
                        break;
                    default:
                        window.location.href = 'property.php';
                        break;
                }
            }
        }
    </script>



    <!----------------- spotlight ------------------>

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
