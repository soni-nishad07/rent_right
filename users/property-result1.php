<?php
session_start();
include('../connection.php');

$is_logged_in = isset($_SESSION['user_id']); // Adjust this condition based on your actual session variable for logged-in users

// Handle search request
$location = '';
$bhkType = '';
$priceRange = '';
$furnishing = '';
$propertyType = '';

if (isset($_POST['location']) && !empty($_POST['location'])) {
    $location = $_POST['location'];
}

if (isset($_POST['bhk_type']) && !empty($_POST['bhk_type'])) {
    $bhkType = $_POST['bhk_type'];
}
if (isset($_POST['price_range']) && !empty($_POST['price_range'])) {
    $priceRange = $_POST['price_range'];
}
if (isset($_POST['furnishing']) && !empty($_POST['furnishing'])) {
    $furnishing = $_POST['furnishing'];
}
if (isset($_POST['property_type']) && !empty($_POST['property_type'])) {
    $propertyType = $_POST['property_type'];
}

$query = "SELECT * FROM properties WHERE 1=1";

if (!empty($location)) {
    $query .= " AND city LIKE '%$location%'";
}
if (!empty($bhkType)) {
    // Modify the query to match both '1bhk' and '1 bhk'
    $query .= " AND REPLACE(bhk_type, ' ', '') = REPLACE('$bhkType', ' ', '')";
}
if (!empty($priceRange)) {
    list($minPrice, $maxPrice) = explode('-', $priceRange);
    $query .= " AND expected_rent BETWEEN $minPrice AND $maxPrice";
}
if (!empty($furnishing)) {
    $query .= " AND furnishing='$furnishing'";
}
if (!empty($propertyType)) {
    $query .= " AND property_type='$propertyType'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listings</title>
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/property2.css">
    <link rel="stylesheet" href="../css/property.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places">
    </script>
    <script src="../js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <?php
    include('../links.php');
    ?>
    <script>
        function initAutocomplete() {
            var input = document.getElementById('location-search');
            var options = {
                types: ['geocode'],
            };
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy,
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>
</head>

<body>

    <?php include('user-head.php');  ?>


    <?php
    // Check if 'id' is set in the URL
    if (isset($_GET['id'])) {
        $propertyId = intval($_GET['id']); // Sanitize input

        // Prepare and execute query to fetch property details
        $query = "SELECT * FROM properties WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $propertyId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the property exists
        if ($result && mysqli_num_rows($result) > 0) {
            $row = $result->fetch_assoc();
            $propertyStatus = htmlspecialchars($row['property_status']); // Fetch property status
            $images = explode(',', $row['file_upload']); // Fetch images

    ?>

            <div class="overlay" id="overlay"></div>
            <main id="main-content">

                <!-- <div class="property_result">
                                <h3 class="fw-bold mb-5">Property <span style="color:#e74c3c">
                                <?php echo htmlspecialchars($propertyStatus); ?> 
                                </span> </h3>
                            </div> -->

                <div class="property_result">
                    <h3 class="fw-bold mb-5">
                        <?php
                        if (isset($propertyStatus) && ($propertyStatus === 'Pending' || $propertyStatus === 'Cancel')) {
                            echo 'Rental Projects in <span style="color:#e74c3c">Bengaluru</span>';
                        } else {
                            echo 'Property <span style="color:#e74c3c">' . htmlspecialchars($propertyStatus) . '</span>';
                        }
                        ?>
                    </h3>
                </div>


                <div class="container">

                    <!-- Property Display -->
                    <div class="row properties">
                        <div class="col-lg-12">
                            <div class="card property-box mb-3">
                                <div class="row g-0">
                                    <div class="col-md-12 col-lg-4 col-sm-12 property-image">
                                        <div class='image-placeholder'>
                                            <?php if (count($images) > 0) { ?>
                                                <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <?php
                                                        foreach ($images as $index => $image) {
                                                            $active = $index == 0 ? 'active' : '';
                                                            echo "<div class='carousel-item $active'>
                                                <img src='$image' class='d-block w-100' alt='Property Image'>
                                              </div>";
                                                        }
                                                        ?>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#propertySlider<?php echo $row['id']; ?>"
                                                        data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button"
                                                        data-bs-target="#propertySlider<?php echo $row['id']; ?>"
                                                        data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-2 col-sm-12 property-details">
                                        <div class="detail-item">Rent- <?php echo $row['expected_rent']; ?></div>
                                        <div class="detail-item">Location - <?php echo $row['city']; ?></div>
                                        <div class="detail-item_area">Area- <?php echo $row['build_up_area']; ?> sqft</div>
                                    </div>

                                    <div class="col-md-12 col-lg-6 col-sm-12">
                                        <div class="property-body">
                                            <div class="property-info">
                                                <div class="info-item">
                                                    <?php echo $row['furnishing']; ?><br><span>Furnishing</span></div>
                                                <div class="info-item"><?php echo $row['bhk_type']; ?><br><span>Apartment
                                                        Type</span></div>
                                                <div class="info-item"><?php echo $row['preferred_tenants']; ?><br><span>Tenant
                                                        Type</span></div>
                                                <div class="info-item">
                                                    <?php echo $row['available_from']; ?><br><span>Available</span></div>
                                            </div>

                                            <div class="property-hylt">
                                                <p class="property-highlight"
                                                    onclick="showPropertyDetails(<?php echo $row['id']; ?>)">
                                                    Property Highlight
                                                </p>

                                                <p class="property-id"><b>Property Id :
                                                    </b><span><?php echo $row['id']; ?></span></p>
                                            </div>

                                            <div class="contact-property">
                                                <div class="contact-button">
                                                    <a class="btn btn-primary book-service"
                                                        data-property-id="<?php echo $row['id']; ?>"
                                                        data-property-type="<?php echo $row['property_type']; ?>"
                                                        data-service-name="<?php echo $row['bhk_type']; ?>"
                                                        onclick="openModalCustom('<?php echo $row['bhk_type']; ?>', '<?php echo $row['property_type']; ?>')">
                                                        Schedule visit
                                                    </a>
                                                    <div class="heart-iocns">
                                                        <i class="fa-regular fa-heart"
                                                            onclick="saveProperty(<?php echo $row['id']; ?>, this)"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    }
                } else {
                    echo "<div class='no-properties'>No properties found based on your filters.</div>";
                }
                        ?>
                </div>



                <?php
                $where_sql = "";

                if (isset($_GET['id'])) {
                    $propertyId = intval($_GET['id']);
                    $where_sql = "WHERE id = $propertyId";
                }
                $query = "SELECT * FROM properties $where_sql";
                $query_run = mysqli_query($conn, $query);
                ?>

                <div class="container">
                    <!-- Recommended Properties Carousel -->
                    <section class="recommended-section">
                        <div class="recommended-heading">
                            <b>Recommended for you</b>
                        </div>
                        <div id="recommendedCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $itemCount = 0;
                                $activeClass = 'active';
                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        $images = explode(',', $row['file_upload']);
                                        if ($itemCount % 3 == 0) {
                                            if ($itemCount != 0) echo '</div></div>';
                                            echo "<div class='carousel-item $activeClass'><div class='row'>";
                                            $activeClass = '';
                                        }
                                ?>
                                        <div class="col-md-4">
                                            <div class="card h-100">
                                                <img src="<?php echo $images[0]; ?>" alt="" class="property-image">
                                                <div class="card-body">
                                                    <p class="card-text"><b>Address</b></p>
                                                    <p class="card-text">
                                                        <?php echo $row['city']; ?>
                                                    </p>
                                                    <a class="book-service" data-property-id="<?php echo $row['id']; ?>"
                                                        data-property-type="<?php echo $row['property_type']; ?>"
                                                        data-service-name="<?php echo $row['bhk_type']; ?>"
                                                        onclick="openModalCustom('<?php echo $row['bhk_type']; ?>', '<?php echo $row['property_type']; ?>')">
                                                        Schedule visit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                        $itemCount++;
                                    }
                                    echo '</div></div>'; // Close the last group
                                }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#recommendedCarousel"
                                data-bs-slide="prev">
                                <div class="icon left"><i class="fa-solid fa-angle-left" id="l"></i></div>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#recommendedCarousel"
                                data-bs-slide="next">
                                <div class="icon right"><i class="fa-solid fa-angle-right" id="r"></i></div>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </section>

                    <!-- Property Search Results -->
                    <section class="property-results">
                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                $images = explode(',', $row['file_upload']);
                        ?>
                                <!-- Property Display -->
                                <div class="row properties">
                                    <div class="col-lg-12">
                                        <div class="card property-box mb-3">
                                            <div class="row g-0">
                                                <div class="col-md-12 col-lg-4 col-sm-12 property-image">
                                                    <div class='image-placeholder'>
                                                        <?php if (count($images) > 0) { ?>
                                                            <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide"
                                                                data-bs-ride="carousel">
                                                                <div class="carousel-inner">
                                                                    <?php
                                                                    foreach ($images as $index => $image) {
                                                                        $active = $index == 0 ? 'active' : '';
                                                                        echo "<div class='carousel-item $active'>
                                                    <img src='$image' class='d-block w-100' alt='Property Image'>
                                                  </div>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <button class="carousel-control-prev" type="button"
                                                                    data-bs-target="#propertySlider<?php echo $row['id']; ?>"
                                                                    data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Previous</span>
                                                                </button>
                                                                <button class="carousel-control-next" type="button"
                                                                    data-bs-target="#propertySlider<?php echo $row['id']; ?>"
                                                                    data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="visually-hidden">Next</span>
                                                                </button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-lg-2 col-sm-12 property-details">
                                                    <div class="detail-item">Rent- <?php echo $row['expected_rent']; ?></div>
                                                    <div class="detail-item">Deposit- <?php echo $row['expected_deposit']; ?></div>
                                                    <div class="detail-item_area">Area- <?php echo $row['build_up_area']; ?> sqft</div>
                                                </div>

                                                <div class="col-md-12 col-lg-6 col-sm-12">
                                                    <div class="property-body">
                                                        <div class="property-info">
                                                            <div class="info-item">
                                                                <?php echo $row['furnishing']; ?><br><span>Furnishing</span></div>
                                                            <div class="info-item"><?php echo $row['bhk_type']; ?><br><span>Apartment
                                                                    Type</span></div>
                                                            <div class="info-item">
                                                                <?php echo $row['preferred_tenants']; ?><br><span>Tenant Type</span>
                                                            </div>
                                                            <div class="info-item">
                                                                <?php echo $row['available_from']; ?><br><span>Available</span></div>
                                                        </div>

                                                        <div class="property-hylt">
                                                            <p class="property-highlight"
                                                                onclick="showPropertyDetails(<?php echo $row['id']; ?>)">
                                                                Property Highlight
                                                            </p>

                                                            <p class="property-id"><b>Property Id : </b>
                                                                <span><?php echo $row['id']; ?></span>
                                                            </p>
                                                        </div>

                                                        <div class="contact-property">
                                                            <div class="contact-button">
                                                                <a class="btn btn-primary book-service"
                                                                    data-property-id="<?php echo $row['id']; ?>"
                                                                    data-property-type="<?php echo $row['property_type']; ?>"
                                                                    data-service-name="<?php echo $row['bhk_type']; ?>"
                                                                    onclick="openModalCustom('<?php echo $row['bhk_type']; ?>', '<?php echo $row['property_type']; ?>')">
                                                                    Schedule visit
                                                                </a>
                                                                <div class="heart-iocns">
                                                                    <i class="fa-regular fa-heart"
                                                                        onclick="saveProperty(<?php echo $row['id']; ?>, this)"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<div class='no-properties'>No properties found based on your filters.</div>";
                        }
                        ?>
                    </section>
                </div>

                <?php
                mysqli_close($conn);
                ?>

                <div class="popup" id="popup">
                    <div class="icon-popup">⚠️</div>
                    <p>Please login first!</p>
                    <button onclick="closePopup()">OK</button>
                </div>

                <!-- property hylight popup -->
                <!-- property modals -->
                <!-- Popup Container -->
                <div id="property_hylt_popup" class="property_hylt_popup">
                    <div class="property_hylt_popup-content">
                        <span class="property_hylt_popup-close" onclick="togglePopup('property_hylt_popup')">&times;</span>
                        <h2>Property Highlights</h2>
                        <ul class="property-hylt-list">
                            <li><span class="p_list">Property type: <?php echo $row['property_type']; ?></span></li>
                            <li><span class="p_list">Property age :<?php echo $row['property_age']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['expected_deposit']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['floor']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['total_floor']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['maintenance']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['parking']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['bathrooms']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['balcony']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['amenities']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['available_for']; ?></span></li>
                            <li><span class="p_list"><?php echo $row['water_supply']; ?></span></li>
                        </ul>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    function showPropertyDetails(propertyId) {
                        // Use AJAX to fetch the property details
                        $.ajax({
                            url: 'fetch_property_details.php',
                            type: 'POST',
                            data: {
                                id: propertyId
                            },
                            success: function(response) {
                                var data = JSON.parse(response);
                                if (!data.error) {
                                    // Populate the popup with the fetched data
                                    $('.property-hylt-list').html(
                                        '<li><span class="p_list">Property type: ' + data.property_type +
                                        '</span></li>' +
                                        '<li><span class="p_list">Property age: ' + data.property_age +
                                        '</span></li>' +
                                        '<li><span class="p_list">Deposit: ' + data.expected_deposit + '/ ' +
                                        '</span></li>' +
                                        '<li><span class="p_list">Floor: ' + data.floor + '</span></li>' +
                                        '<li><span class="p_list">Total Floors: ' + data.total_floor +
                                        '</span></li>' +
                                        '<li><span class="p_list">Maintenance: ' + data.maintenance +
                                        '</span></li>' +
                                        '<li><span class="p_list">Parking: ' + data.parking + '</span></li>' +
                                        '<li><span class="p_list">Bathrooms: ' + data.bathrooms +
                                        '</span></li>' +
                                        '<li><span class="p_list">Balcony: ' + data.balcony + '</span></li>' +
                                        '<li><span class="p_list">Amenities: ' + data.amenities +
                                        '</span></li>' +
                                        '<li><span class="p_list">Available for: ' + data.available_for +
                                        '</span></li>' +
                                        '<li><span class="p_list">Water Supply: ' + data.water_supply +
                                        '</span></li>'
                                    );
                                    // Show the popup
                                    togglePopup('property_hylt_popup');
                                } else {
                                    alert(data.error);
                                }
                            },
                            error: function() {
                                alert('Failed to fetch property details.');
                            }
                        });
                    }

                    function togglePopup(popupId) {
                        var popup = document.getElementById(popupId);
                        popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
                    }
                </script>

                <!-- Modal for Booking Form -->
                <div id="customModal" class="modal-custom">
    <div class="modal-content-custom">
        <span class="close-custom" onclick="closeModalCustom()">&times;</span>
        <h1 class="booking_for-custom">Schedule a Visit: <span id="modalTitleCustom"></span></h1>
        <form id="bookingFormCustom" action="../service-insert.php" method="POST" onsubmit="return validateFormCustom()">
            <input type="hidden" id="booking_id_custom" name="booking_id" value="">
            <input type="hidden" id="service_name_custom" name="service_name" value="">
            <input type="hidden" id="booking_status_custom" name="booking_status" value="pending">
            
            <div class="input-group-custom">
                <input type="text" id="name_custom" name="name" placeholder="Name" required>
            </div>
            <div class="input-group-custom">
                <input type="email" id="email_custom" name="email" placeholder="Email" required>
            </div>
            <div class="input-group-custom">
                <input type="number" id="mobile_custom" name="mobile" placeholder="Mobile Number" required>
            </div>

            <div class="input-group-custom">
                <!-- <span>Provide Date For Booking!</span> -->
            </div>
            <button type="submit" name="book-services" class="book-services-custom">Schedule a Visit</button>
        </form>
    </div>
</div>

<script>
    // Open Modal
    function openModalCustom(serviceName, propertyType) {
        document.getElementById("modalTitleCustom").innerText = propertyType;
        document.getElementById("service_name_custom").value = serviceName;
        document.getElementById("customModal").style.display = "block";
        document.getElementById("booking_id_custom").value = generateBookingIDCustom();
    }

    // Close Modal
    function closeModalCustom() {
        document.getElementById("customModal").style.display = "none";
    }

    // Close Modal When Clicking Outside
    window.onclick = function (event) {
        if (event.target == document.getElementById("customModal")) {
            closeModalCustom();
        }
    };

    // Validate Form
    function validateFormCustom() {
        const name = document.getElementById("name_custom").value.trim();
        const email = document.getElementById("email_custom").value.trim();
        const mobile = document.getElementById("mobile_custom").value.trim();

        if (!name || !email || !mobile) {
            alert("All fields must be filled out");
            return false;
        }

        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if (!email.match(emailPattern)) {
            alert("Please enter a valid email address");
            return false;
        }

        const mobilePattern = /^[0-9]{10}$/;
        if (!mobile.match(mobilePattern)) {
            alert("Please enter a valid 10-digit mobile number");
            return false;
        }

        return true;
    }

    // Generate Unique Booking ID
    function generateBookingIDCustom() {
        return `booking_${Date.now()}`;
    }
</script>



                <script>
                    const isLoggedIn = <?php echo json_encode($is_logged_in); ?>;

                    function showPopup() {
                        document.getElementById('popup').style.display = 'block';
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('main-content').classList.add('blur');
                    }

                    function closePopup() {
                        document.getElementById('popup').style.display = 'none';
                        document.getElementById('overlay').style.display = 'none';
                        document.getElementById('main-content').classList.remove('blur');
                        window.location.href = '../login'; // Redirect to login page after closing popup
                    }

                    function resetSearch() {
                        document.getElementById('location-search').value = '';
                        // Clear the search form and optionally reload the page
                        window.location.href = 'property.php'; // Reload property.php to reset search
                    }

                    function saveProperty(propertyId, iconElement) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'save_items.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var response = xhr.responseText;
                                if (response === 'saved') {
                                    iconElement.classList.add('saved');
                                    iconElement.classList.remove('fa-regular');
                                    iconElement.classList.add('fa-solid');
                                } else if (response === 'already_saved') {
                                    alert('Property already saved.');
                                } else {
                                    alert('Saved successfully');
                                }
                            } else {
                                alert('Request failed.');
                            }
                        };
                        xhr.send('property_id=' + encodeURIComponent(propertyId));
                    }
                </script>



                <script src="../js/script.js"></script>

                <?php
                include('../footer.php');
                ?>

</body>

</html>