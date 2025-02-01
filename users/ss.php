<?php
session_start();
include('../connection.php');

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// Sanitize function to prevent SQL Injection
function sanitize($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Initialize variables
$location = '';
$city = '';
$state = '';
$bhkType = '';
$priceRange = '';
$furnishing = '';
$propertyType = '';
$error_message = '';
$properties = [];

// Handle search request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['area']) && !empty($_POST['area'])) {
        $location = sanitize($_POST['area']);
    }
    if (isset($_POST['city']) && !empty($_POST['city'])) {
        $city = sanitize($_POST['city']);
    }
    if (isset($_POST['state']) && !empty($_POST['state'])) {
        $state = sanitize($_POST['state']);
    }
    if (isset($_POST['bhk_type']) && !empty($_POST['bhk_type'])) {
        $bhkType = sanitize($_POST['bhk_type']);
    }
    if (isset($_POST['price_range']) && !empty($_POST['price_range'])) {
        $priceRange = sanitize($_POST['price_range']);
    }
    if (isset($_POST['furnishing']) && !empty($_POST['furnishing'])) {
        $furnishing = sanitize($_POST['furnishing']);
    }
    if (isset($_POST['property_type']) && !empty($_POST['property_type'])) {
        $propertyType = sanitize($_POST['property_type']);
    }

    // Build the query
    $query = "SELECT * FROM properties WHERE approval_status = 'Approved'";

    if (!empty($location)) {
        $query .= " AND area LIKE '%$location%'";
    }
    if (!empty($city)) {
        $query .= " AND city LIKE '%$city%'";
    }
    if (!empty($state)) {
        $query .= " AND state LIKE '%$state%'";
    }
    if (!empty($bhkType)) {
        $query .= " AND REPLACE(bhk_type, ' ', '') = REPLACE('$bhkType', ' ', '')";
    }
    if (!empty($priceRange)) {
        if (strpos($priceRange, '-') !== false) {
            list($minPrice, $maxPrice) = explode('-', $priceRange);
            $query .= " AND expected_deposit BETWEEN $minPrice AND $maxPrice";
        }
    }
    if (!empty($furnishing)) {
        $query .= " AND furnishing = '$furnishing'";
    }
    if (!empty($propertyType)) {
        $query .= " AND property_type = '$propertyType'";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $properties[] = $row;
        }
    } else {
        $error_message = "No properties found based on your search criteria.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listings</title>
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/property.css">
    <link rel="stylesheet" href="../css/property2.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY&libraries=places"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Custom styles for the page */
        .i.fa-regular.fa-heart {
            font-size: 24px !important;
            margin: 10px 25px !important;
            color: #4f4f4f;
        }

        .modal {
            position: fixed;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%);
            z-index: 1000;
            display: none;
        }

        .property-box-cont {
            margin-top: 60px !important;
        }
    </style>
    <?php include('../links.php'); ?>
    <script>
        // Initialize Google Places API Autocomplete
        function initAutocomplete() {
            var areaInput = document.getElementById('area');
            var options = {
                types: ['geocode'],
            };

            var autocomplete = new google.maps.places.Autocomplete(areaInput, options);

            // Optional: Automatically center the results based on user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                });
            }
        }
    </script>
</head>

<body onload="initAutocomplete()">
    <section class="locations-property">
        <div class="location-tags">
            <form action="" method="post" class="form-group location-form">
                <i class="fa-solid fa-location-dot location-icons"></i>

                <!-- Area Search Field -->
                <input type="text" id="area" name="area" placeholder="Enter Area" class="form-control" value="<?php echo htmlspecialchars($location); ?>" required>
                <input type="text" id="city" name="city" placeholder="Enter City" class="form-control" value="<?php echo htmlspecialchars($city); ?>">

                <!-- State Dropdown -->
                <select id="state" name="state" class="form-control">
                    <option value="">Select State</option>
                    <option value="Andhra Pradesh" <?php echo $state == 'Andhra Pradesh' ? 'selected' : ''; ?>>Andhra Pradesh</option>
                    <!-- Add more states as needed -->
                </select>

                <button type="submit" class="btn" style="color:red;">Search</button>

                <button type="button" class="btn" onclick="window.location.href='search_property.php'">
                    <i class="fa fa-refresh plus_location" aria-hidden="true"></i>
                </button>
            </form>
        </div>

        <div class="location-btn">
            <a class="saved-property" href="<?php echo $is_logged_in ? 'save.php' : '#'; ?>" onclick="<?php echo $is_logged_in ? '' : 'showPopup(); return false;'; ?>">
                Saved Properties<i class="fas fa-heart" style="color: red; padding-left: 5px;"></i>
            </a>
        </div>
    </section>

    <!-- Property Listings -->
    <div class="container">
        <?php if (!empty($properties)): ?>
            <div class="row">
                <?php foreach ($properties as $row): ?>
                    <div class="col-lg-12 mb-3">
                        <div class="card property-box">
                            <div class="row g-0">
                                <div class="col-md-12 col-lg-4 property-image">
                                    <div class='image-placeholder'>
                                        <?php $images = explode(',', $row['file_upload']); ?>
                                        <?php if (count($images) > 0): ?>
                                            <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php foreach ($images as $index => $image): ?>
                                                        <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>"  onclick="openImagePopup(<?php echo $row['id']; ?>)">
                                                            <img src="<?php echo $image; ?>" class="d-block w-100" alt="Property Image">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-2 property-details">
                                    <div class="detail-item">Rent- <?php echo htmlspecialchars($row['expected_rent']); ?></div>
                                    <div class="detail-item">Location - <?php echo htmlspecialchars($row['area']); ?></div>
                                    <div class="detail-item_area">Area- <?php echo htmlspecialchars($row['build_up_area']); ?> sqft</div>
                                </div>

                                <div class="col-md-12 col-lg-6">
                                    <div class="property-body">
                                        <div class="property-info">
                                            <div class="info-item"><?php echo htmlspecialchars($row['furnishing']); ?><br><span>Furnishing</span></div>
                                            <div class="info-item"><?php echo htmlspecialchars($row['bhk_type']); ?><br><span>Apartment Type</span></div>
                                            <div class="info-item"><?php echo htmlspecialchars($row['preferred_tenants']); ?><br><span>Tenant Type</span></div>
                                            <div class="info-item"><?php echo htmlspecialchars($row['available_from']); ?><br><span>Available</span></div>
                                        </div>

                                        <div class="property-hylt">
                                            <p class="property-highlight" onclick="showPropertyDetails(<?php echo $row['id']; ?>)">Property Highlight</p>
                                            <p class="property-id"><b>Property Id :</b> <span><?php echo htmlspecialchars($row['id']); ?></span></p>
                                        </div>

                                        <div class="contact-property">
                                            <div class="contact-button">
                                                <a class="btn btn-primary book-service" data-property-id="<?php echo $row['id']; ?>" onclick="openModalCustom('<?php echo $row['bhk_type']; ?>', '<?php echo $row['property_type']; ?>')">Schedule visit </a>
                                                <div class="heart-icons">
                                                    <i class="fa-regular fa-heart" onclick="saveProperty(<?php echo $row['id']; ?>, this)"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                          <!-- Popup Modal -->
                          <div class="modal fade" id="imagePopup<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="imagePopupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imagePopupLabel">Property Images</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="popupCarousel<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php foreach ($images as $index => $image): ?>
                                                <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                                                    <img src="<?php echo htmlspecialchars($image); ?>" class="d-block w-100 h-100 pop_img" alt="Property Image">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#popupCarousel<?php echo $row['id']; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#popupCarousel<?php echo $row['id']; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-properties">No properties found based on your search criteria.</div>
        <?php endif; ?>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"></script>

</body>

</html>