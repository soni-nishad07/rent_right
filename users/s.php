<?php
session_start();
include('../connection.php');

$is_logged_in = isset($_SESSION['user_id']); // Adjust this condition based on your actual session variable for logged-in users

// Handle search request
$location = '';
$city = '';
$state = '';
$bhkType = '';
$priceRange = '';
$furnishing = '';
$propertyType = '';

if (isset($_POST['area']) && !empty($_POST['area'])) {
    $location = $_POST['area'];
}

if (isset($_POST['city']) && !empty($_POST['city'])) {
    $city = $_POST['city'];
}
if (isset($_POST['state']) && !empty($_POST['state'])) {
    $state = $_POST['state'];
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
    $query .= " AND area LIKE '%$location%'";
}
if (!empty($city)) {
    $query .= " AND city LIKE '%$city%'";
}
if (!empty($state)) {
    $query .= " AND state LIKE '%$state%'";
}
if (!empty($bhkType)) {
    // Modify the query to match both '1bhk' and '1 bhk'
    $query .= " AND REPLACE(bhk_type, ' ', '') = REPLACE('$bhkType', ' ', '')";
}
if (!empty($priceRange)) {
    list($minPrice, $maxPrice) = explode('-', $priceRange);
    $query .= " AND expected_deposit BETWEEN $minPrice AND $maxPrice";
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
    <!-- <script>
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
    </script> -->

    <script>
        function initAutocomplete() {
            var areaInput = document.getElementById('area');
            var options = {
                types: ['geocode'],
            };

            var autocomplete = new google.maps.places.Autocomplete(areaInput, options);

            var cityInput = document.getElementById('city');
            var cityAutocomplete = new google.maps.places.Autocomplete(cityInput, options);

            var stateInput = document.getElementById('state');
            var stateAutocomplete = new google.maps.places.Autocomplete(stateInput, options);

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
                    cityAutocomplete.setBounds(circle.getBounds());
                    stateAutocomplete.setBounds(circle.getBounds());
                });
            }
        }

        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>

</head>

<body>

    <?php include('user-head.php');  ?>


    <div class="overlay" id="overlay"></div>
    <main id="main-content">


        <section class="locations-property">

    <div class="location-btn">
        <a class="saved-property" href="<?php echo $is_logged_in ? 's1.php' : '#'; ?>" onclick="<?php echo $is_logged_in ? '' : 'showPopup(); return false;'; ?>">
            Saved Properties<i class="fas fa-heart" style="color: red; padding-left: 5px;"></i>
        </a>
    </div>
</section>


        <?php
        include('../connection.php');


        // Initialize search parameters
        $location = isset($_POST['area']) ? $_POST['area'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $state = isset($_POST['state']) ? $_POST['state'] : '';
        
        $bhkType = isset($_POST['bhk_type']) ? $_POST['bhk_type'] : '';
        $priceRange = isset($_POST['price_range']) ? $_POST['price_range'] : '';
        $furnishing = isset($_POST['furnishing']) ? $_POST['furnishing'] : '';
        $propertyType = isset($_POST['property_type']) ? $_POST['property_type'] : '';

        // Initialize filter parameters from GET
        $preferredTenants = isset($_GET['preferred_tenants']) ? $_GET['preferred_tenants'] : [];
        $floors = isset($_GET['floors']) ? $_GET['floors'] : [];
        $minArea = isset($_GET['min_area']) && is_numeric($_GET['min_area']) ? (float)$_GET['min_area'] : null;
        $maxArea = isset($_GET['max_area']) && is_numeric($_GET['max_area']) ? (float)$_GET['max_area'] : null;
        $propertyAges = isset($_GET['property_age']) ? $_GET['property_age'] : [];
        $parkingOptions = isset($_GET['parking']) ? $_GET['parking'] : [];
        $amenities = isset($_GET['amenities']) ? $_GET['amenities'] : [];

        // Construct WHERE clauses
        $where_clauses = [];

        // Form-based search conditions
        // if (!empty($location)) {
        //     $where_clauses[] = "city LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
        // }

        if (!empty($location)) {
            $where_clauses[] = "area LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
        }
        if (!empty($city)) {
            $where_clauses[] = "city LIKE '%" . mysqli_real_escape_string($conn, $city) . "%'";
        }
        if (!empty($state)) {
            $where_clauses[] = "state LIKE '%" . mysqli_real_escape_string($conn, $state) . "%'";
        }



        if (!empty($bhkType)) {
            $where_clauses[] = "REPLACE(bhk_type, ' ', '') = REPLACE('" . mysqli_real_escape_string($conn, $bhkType) . "', ' ', '')";
        }
        if (!empty($priceRange)) {
            list($minPrice, $maxPrice) = explode('-', $priceRange);
            $where_clauses[] = "expected_deposit BETWEEN " . (float)$minPrice . " AND " . (float)$maxPrice;
        }
        if (!empty($furnishing)) {
            $where_clauses[] = "furnishing='" . mysqli_real_escape_string($conn, $furnishing) . "'";
        }
        if (!empty($propertyType)) {
            $where_clauses[] = "property_type='" . mysqli_real_escape_string($conn, $propertyType) . "'";
        }

        // Filter-based conditions
        if (!empty($preferredTenants)) {
            $tenant_clauses = [];
            foreach ($preferredTenants as $tenant) {
                $tenant_clauses[] = "preferred_tenants LIKE '%" . mysqli_real_escape_string($conn, $tenant) . "%'";
            }
            if (count($tenant_clauses) > 0) {
                $where_clauses[] = "(" . implode(" OR ", $tenant_clauses) . ")";
            }
        }
        if (!empty($floors)) {
            $floor_clauses = [];
            foreach ($floors as $floor) {
                $floor_clauses[] = "floor = '" . mysqli_real_escape_string($conn, $floor) . "'";
            }
            if (count($floor_clauses) > 0) {
                $where_clauses[] = "(" . implode(" OR ", $floor_clauses) . ")";
            }
        }
        if (!is_null($minArea)) {
            $where_clauses[] = "build_up_area >= " . (float)$minArea;
        }
        if (!is_null($maxArea)) {
            $where_clauses[] = "build_up_area <= " . (float)$maxArea;
        }
        if (!empty($propertyAges)) {
            $age_clauses = [];
            foreach ($propertyAges as $age) {
                if ($age == '< 1 Year') {
                    $age_clauses[] = "property_age < 1";
                } elseif ($age == '< 3 Years') {
                    $age_clauses[] = "property_age < 3";
                } elseif ($age == '< 5 Years') {
                    $age_clauses[] = "property_age < 5";
                } elseif ($age == '< 10 Years') {
                    $age_clauses[] = "property_age < 10";
                }
            }
            if (count($age_clauses) > 0) {
                $where_clauses[] = "(" . implode(" OR ", $age_clauses) . ")";
            }
        }
        if (!empty($parkingOptions)) {
            $parking_clauses = [];
            foreach ($parkingOptions as $parking) {
                $parking_clauses[] = "parking = '" . mysqli_real_escape_string($conn, $parking) . "'";
            }
            if (count($parking_clauses) > 0) {
                $where_clauses[] = "(" . implode(" OR ", $parking_clauses) . ")";
            }
        }
        if (!empty($amenities)) {
            $amenity_clauses = [];
            foreach ($amenities as $amenity) {
                $amenity_clauses[] = "amenities LIKE '%" . mysqli_real_escape_string($conn, $amenity) . "%'";
            }
            if (count($amenity_clauses) > 0) {
                $where_clauses[] = "(" . implode(" OR ", $amenity_clauses) . ")";
            }
        }



        $where_clauses[] = "approval_status = 'Approved'"; // Ensure only approved properties are shown



        // Combine all where clauses
        $where_sql = "";
        if (count($where_clauses) > 0) {
            $where_sql = "WHERE " . implode(' AND ', $where_clauses);
        }

        // Final query
        $query = "SELECT * FROM properties $where_sql";
        $query_run = mysqli_query($conn, $query);
        ?>

<div class="container">
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
                            <!-- Property Images -->
                            <div class="col-md-12 col-lg-4 col-sm-12 property-image">
                                <div class="image-placeholder">
                                    <?php if (count($images) > 0) { ?>
                                        <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
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
                                            <button class="carousel-control-prev" type="button" data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Property Details -->
                            <div class="col-md-12 col-lg-2 col-sm-12 property-details">
                                <div class="detail-item">Rent: <?php echo $row['expected_rent']; ?></div>
                                <div class="detail-item">Location: <?php echo $row['area']; ?></div>
                                <div class="detail-item_area">Area: <?php echo $row['build_up_area']; ?> sqft</div>
                            </div>

                            <!-- Additional Information -->
                            <div class="col-md-12 col-lg-6 col-sm-12">
                                <div class="property-body">
                                    <div class="property-info">
                                        <div class="info-item">
                                            <?php echo $row['furnishing']; ?><br><span>Furnishing</span>
                                        </div>
                                        <div class="info-item">
                                            <?php echo $row['bhk_type']; ?><br><span>Apartment Type</span>
                                        </div>
                                        <div class="info-item">
                                            <?php echo $row['preferred_tenants']; ?><br><span>Tenant Type</span>
                                        </div>
                                        <div class="info-item">
                                            <?php echo $row['available_from']; ?><br><span>Available</span>
                                        </div>
                                    </div>

                                    <div class="property-hylt">
                                        <p class="property-highlight" onclick="showPropertyDetails(<?php echo $row['id']; ?>)">
                                            Property Highlight
                                        </p>
                                        <p class="property-id"><b>Property Id:</b> <span><?php echo $row['id']; ?></span></p>
                                    </div>

                                    <div class="contact-property">
                                        <div class="contact-button">
                                            <a class="btn btn-primary book-service"
                                                data-property-id="<?php echo $row['id']; ?>"
                                                onclick="openModalCustom('<?php echo $row['bhk_type']; ?>', '<?php echo $row['property_type']; ?>')">
                                                Schedule Visit
                                            </a>
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
            </div>
    <?php
        }
    } else {
        echo "<div class='no-properties'>No properties found based on your filters.</div>";
    }
    ?>
</div>

 
        <div class="popup" id="popup">
            <div class="icon-popup">⚠️</div>
            <p>Please login first!</p>
            <button onclick="closePopup()">OK</button>
        </div>



        <!-- saved property -->

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
    xhr.open('POST', 's1.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            if (response === 'saved') {
                iconElement.classList.add('fa-solid', 'saved');
                iconElement.classList.remove('fa-regular');
            } else if (response === 'already_saved') {
                alert('Property already saved.');
            } else {
                alert('Failed to save property.');
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