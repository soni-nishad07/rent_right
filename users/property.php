<?php
session_start();
include('../connection.php');

$is_logged_in = isset($_SESSION['user_id']); // Adjust this condition based on your actual session variable for logged-in users

// Handle search request
$location = '';
$city = '';
$state = '' ;
$bhkType = '';
$priceRange = '';
$furnishing = '';
$propertyType = '';

// if (isset($_POST['location']) && !empty($_POST['location'])) {
//     $location = $_POST['location'];
// }


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

// $query = "SELECT * FROM properties WHERE approval_status = 'Approved'";



// if (!empty($location)) {
//     $query .= " AND city LIKE '%$location%'";
// }

// if (!empty($location)) {
//     $query .= " AND area LIKE '%$location%'";
// }


// if (!empty($city)) {
//     $query .= " AND city LIKE '%$city%'";
// }


// if (!empty($state)) {
//     $query .= " AND state LIKE '%$state%'";
// }

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
    // Initialize the Google Places API Autocomplete
    function initAutocomplete() {
        // Initialize Autocomplete for area input
        var areaInput = document.getElementById('area');
        var options = {
            types: ['geocode'],  // Restrict results to locations
        };

        var autocomplete = new google.maps.places.Autocomplete(areaInput, options);

        // Add autocomplete for city and state as well if needed
        var cityInput = document.getElementById('city');
        var cityAutocomplete = new google.maps.places.Autocomplete(cityInput, options);

        var stateInput = document.getElementById('state');
        var stateAutocomplete = new google.maps.places.Autocomplete(stateInput, options);

        // Optional: Automatically center the results based on user's location
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

    // Load the Google Maps API script
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>


</head>



<body>

    <?php include('user-head.php');  ?>

    <div class="overlay" id="overlay"></div>
    <main id="main-content">

        <div class="property-filter2">
            <div class="filters">
                <div class="dropdown2">
                    <form action="" method="post">
                        <label for="Rent">Rent</label>

                        <select id="bhk_type" name="bhk_type">
                            <option value="">BHK Type</option>
                            <option value="1 BHK" <?php echo $bhkType == '1 BHK' ? 'selected' : ''; ?>>1 BHK</option>
                            <option value="2 BHK" <?php echo $bhkType == '2 BHK' ? 'selected' : ''; ?>>2 BHK</option>
                            <option value="3 BHK" <?php echo $bhkType == '3 BHK' ? 'selected' : ''; ?>>3 BHK</option>
                            <option value="4 BHK" <?php echo $bhkType == '4 BHK' ? 'selected' : ''; ?>>4 BHK</option>
                            <option value="5 BHK" <?php echo $bhkType == '5 BHK' ? 'selected' : ''; ?>>5 BHK</option>
                            <option value="Independent House"
                                <?php echo $bhkType == 'Independent House' ? 'selected' : ''; ?>>Independent House
                            </option>

                            <option value="1RK" <?php echo $bhkType == '1RK' ? 'selected' : ''; ?>>1 RK</option>
                            <option value="CommercialSpace" <?php echo $bhkType == 'CommercialSpace' ? 'selected' : ''; ?>>Commercial Space</option>
                            <option value="Land" <?php echo $bhkType == 'Land' ? 'selected' : ''; ?>>Land</option>
                            <option value="CompleteBuilding" <?php echo $bhkType == 'CompleteBuilding' ? 'selected' : ''; ?>>Complete Building</option>
                            <option value="Bungalow" <?php echo $bhkType == 'Bungalow' ? 'selected' : ''; ?>>Bungalow</option>
                            <option value="Villa" <?php echo $bhkType == 'Villa' ? 'selected' : ''; ?>>Villa</option>
                        </select>

                        <select id="price_range" name="price_range">
                            <option value="">Price Range</option>
                            <option value="5000-10000" <?php echo $priceRange == '5000-10000' ? 'selected' : ''; ?>>5,000 - 10,000</option>
                            <option value="10000-30000" <?php echo $priceRange == '10000-30000' ? 'selected' : ''; ?>>10,000 - 30,000</option>
                            <option value="30000-50000" <?php echo $priceRange == '30000-50000' ? 'selected' : ''; ?>>30,000 - 50,000</option>
                            <option value="50000-100000" <?php echo $priceRange == '50000-100000' ? 'selected' : ''; ?>>50,000 - 100,000</option>
                            <option value="100000-150000" <?php echo $priceRange == '100000-150000' ? 'selected' : ''; ?>>100,000 - 150,000</option>
                            <option value="150000-200000" <?php echo $priceRange == '150000-200000' ? 'selected' : ''; ?>>150,000 - 200,000</option>
                            <option value="200000-250000" <?php echo $priceRange == '200000-250000' ? 'selected' : ''; ?>>200,000 - 250,000</option>
                            <option value="250000-300000" <?php echo $priceRange == '250000-300000' ? 'selected' : ''; ?>>250,000 - 300,000</option>
                            <option value="300000-350000" <?php echo $priceRange == '300000-350000' ? 'selected' : ''; ?>>300,000 - 350,000</option>
                            <option value="350000-400000" <?php echo $priceRange == '350000-400000' ? 'selected' : ''; ?>>350,000 - 400,000</option>
                            <option value="400000-450000" <?php echo $priceRange == '400000-450000' ? 'selected' : ''; ?>>400,000 - 450,000</option>
                            <option value="450000-480000" <?php echo $priceRange == '450000-480000' ? 'selected' : ''; ?>>450,000 - 480,000</option>
                            <option value="480000-500000" <?php echo $priceRange == '480000-500000' ? 'selected' : ''; ?>>480,000 - 500,000</option>
                            <option value="500000-above" <?php echo $priceRange == '500000-above' ? 'selected' : ''; ?>>500,000 and Above</option>
                        </select>


                        <select id="furnishing" name="furnishing">
                            <option value="">Select Furnishing</option>
                            <option value="Fully-Furnished"
                                <?php echo $furnishing == 'Fully-Furnished' ? 'selected' : ''; ?>>
                                Fully-Furnished
                            </option>
                            <option value="Semi-Furnished"
                                <?php echo $furnishing == 'Semi-Furnished' ? 'selected' : ''; ?>>
                                Semi-Furnished</option>
                            <option value="Unfurnished" <?php echo $furnishing == 'Unfurnished' ? 'selected' : ''; ?>>
                                Unfurnished</option>
                        </select>

                        <select id="property_type" name="property_type">
                            <option value="">Property Type</option>
                            <option value="Flat" <?php echo $propertyType == 'Flat' ? 'selected' : ''; ?>>Flat</option>
                            <option value="Building" <?php echo $propertyType == 'Building' ? 'selected' : ''; ?>>
                                Building
                            </option>
                            <option value="Site" <?php echo $propertyType == 'Site' ? 'selected' : ''; ?>>Site</option>
                            <option value="Commercial" <?php echo $propertyType == 'Commercial' ? 'selected' : ''; ?>>
                                Commercial</option>
                            <option value="Villa" <?php echo $propertyType == 'Villa' ? 'selected' : ''; ?>>Villa
                            </option>
                        </select>

                        <button type="submit" class="btn">Search</button>
                    </form>
                </div>
            </div>

            <div class="filters-btn2">
                <a href="property2.php">More Filters</a>
            </div>

        </div>

        <!-- <section class="locations-property">
            <div class="location-tags">
                <form action="" method="post" class="form-group location-form">
                    <i class="fa-solid fa-location-dot location-icons"></i>
                    <input type="search" name="location" placeholder="Type Your Location" id="location-search"
                        class="form-control locationsearch" value="<?php echo htmlspecialchars($location); ?>">
                    <button type="button" class="btn" onclick="window.location.href='property.php'">
                        <i class="fa fa-refresh plus_location" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <div class="location-btn">
                <a class="saved-property" href="<?php echo $is_logged_in ? 'save.php' : '#'; ?>"
                    onclick="<?php echo $is_logged_in ? '' : 'showPopup(); return false;'; ?>">
                    Saved Properties<i class="fas fa-heart" style="color: red; padding-left: 5px;"></i>
                </a>
            </div>
        </section> -->




        <section class="locations-property">
    <div class="location-tags">
        <form action="" method="post" class="form-group location-form">
            <i class="fa-solid fa-location-dot location-icons"></i>

            <!-- Area Search Field -->
            <input type="text" id="area" name="area" placeholder="Enter Area" class="form-control" value="<?php echo htmlspecialchars($location); ?>" required>
            <input type="text" id="city" name="city" placeholder="Enter City" class="form-control" value="<?php echo htmlspecialchars($city); ?>" >
            <!-- <input type="text" id="state" name="state" placeholder="Enter State" class="form-control" 
            value="<?php echo htmlspecialchars($state); ?>" > -->

            <!-- State Dropdown -->
            <select id="state" name="state" class="form-control" >
                <option value="">Select State</option>
                <option value="Andhra Pradesh" <?php echo $state == 'Andhra Pradesh' ? 'selected' : ''; ?>>Andhra Pradesh</option>
                <option value="Arunachal Pradesh" <?php echo $state == 'Arunachal Pradesh' ? 'selected' : ''; ?>>Arunachal Pradesh</option>
                <option value="Assam" <?php echo $state == 'Assam' ? 'selected' : ''; ?>>Assam</option>
                <option value="Bihar" <?php echo $state == 'Bihar' ? 'selected' : ''; ?>>Bihar</option>
                <option value="Chhattisgarh" <?php echo $state == 'Chhattisgarh' ? 'selected' : ''; ?>>Chhattisgarh</option>
                <option value="Goa" <?php echo $state == 'Goa' ? 'selected' : ''; ?>>Goa</option>
                <option value="Gujarat" <?php echo $state == 'Gujarat' ? 'selected' : ''; ?>>Gujarat</option>
                <option value="Haryana" <?php echo $state == 'Haryana' ? 'selected' : ''; ?>>Haryana</option>
                <option value="Himachal Pradesh" <?php echo $state == 'Himachal Pradesh' ? 'selected' : ''; ?>>Himachal Pradesh</option>
                <option value="Jharkhand" <?php echo $state == 'Jharkhand' ? 'selected' : ''; ?>>Jharkhand</option>
                <option value="Karnataka" <?php echo $state == 'Karnataka' ? 'selected' : ''; ?>>Karnataka</option>
                <option value="Kerala" <?php echo $state == 'Kerala' ? 'selected' : ''; ?>>Kerala</option>
                <option value="Madhya Pradesh" <?php echo $state == 'Madhya Pradesh' ? 'selected' : ''; ?>>Madhya Pradesh</option>
                <option value="Maharashtra" <?php echo $state == 'Maharashtra' ? 'selected' : ''; ?>>Maharashtra</option>
                <option value="Manipur" <?php echo $state == 'Manipur' ? 'selected' : ''; ?>>Manipur</option>
                <option value="Meghalaya" <?php echo $state == 'Meghalaya' ? 'selected' : ''; ?>>Meghalaya</option>
                <option value="Mizoram" <?php echo $state == 'Mizoram' ? 'selected' : ''; ?>>Mizoram</option>
                <option value="Nagaland" <?php echo $state == 'Nagaland' ? 'selected' : ''; ?>>Nagaland</option>
                <option value="Odisha" <?php echo $state == 'Odisha' ? 'selected' : ''; ?>>Odisha</option>
                <option value="Punjab" <?php echo $state == 'Punjab' ? 'selected' : ''; ?>>Punjab</option>
                <option value="Rajasthan" <?php echo $state == 'Rajasthan' ? 'selected' : ''; ?>>Rajasthan</option>
                <option value="Sikkim" <?php echo $state == 'Sikkim' ? 'selected' : ''; ?>>Sikkim</option>
                <option value="Tamil Nadu" <?php echo $state == 'Tamil Nadu' ? 'selected' : ''; ?>>Tamil Nadu</option>
                <option value="Telangana" <?php echo $state == 'Telangana' ? 'selected' : ''; ?>>Telangana</option>
                <option value="Tripura" <?php echo $state == 'Tripura' ? 'selected' : ''; ?>>Tripura</option>
                <option value="Uttar Pradesh" <?php echo $state == 'Uttar Pradesh' ? 'selected' : ''; ?>>Uttar Pradesh</option>
                <option value="Uttarakhand" <?php echo $state == 'Uttarakhand' ? 'selected' : ''; ?>>Uttarakhand</option>
                <option value="West Bengal" <?php echo $state == 'West Bengal' ? 'selected' : ''; ?>>West Bengal</option>
                <option value="Andaman and Nicobar Islands" <?php echo $state == 'Andaman and Nicobar Islands' ? 'selected' : ''; ?>>Andaman and Nicobar Islands</option>
                <option value="Chandigarh" <?php echo $state == 'Chandigarh' ? 'selected' : ''; ?>>Chandigarh</option>
                <option value="Dadra and Nagar Haveli and Daman and Diu" <?php echo $state == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : ''; ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                <option value="Lakshadweep" <?php echo $state == 'Lakshadweep' ? 'selected' : ''; ?>>Lakshadweep</option>
                <option value="Delhi" <?php echo $state == 'Delhi' ? 'selected' : ''; ?>>Delhi</option>
                <option value="Puducherry" <?php echo $state == 'Puducherry' ? 'selected' : ''; ?>>Puducherry</option>
            </select>


            <button type="submit" class="btn"  style="color:red;">Search</button>

            <button type="button" class="btn" onclick="window.location.href='property.php'">
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



        <?php
        // Initialize search parameters
        // $location = isset($_POST['location']) ? $_POST['location'] : '';

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
                                        <div class="detail-item">Location - <?php echo $row['area']; ?></div>
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
        mysqli_close($conn);
        ?>




        <!-------------------------------------------------------------------------------------------------------------------------->
        <!-- -------------------------------------------------------------------------------------------------- -->
        <!-- ---------------------------------------------------------------------- -->
        <!-- ----------------------------------------------------------------- -->





        <?php
        include('../connection.php');

        // Initialize search parameters
        // $location = isset($_POST['location']) ? $_POST['location'] : '';
        
        
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
            $where_clauses[] = "expected_rent BETWEEN " . (float)$minPrice . " AND " . (float)$maxPrice;
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
                                                <?php echo $row['area']; ?>
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
                <h1 class="booking_for-custom"> Schedule a Visit: <span id="modalTitleCustom"></span></h1>
                <form id="bookingFormCustom" action="../service-insert.php" method="POST"
                    onsubmit="return validateFormCustom()">
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
                        <input type="date" id="booking_date_custom" name="booking_date" required>
                    </div>
                    <div class="input-group-custom">
                        <span>Provide Date For Booking!</span>
                    </div>
                    <button type="submit" name="book-services" class="book-services-custom">Schedule a Visit</button>
                </form>
            </div>
        </div>




        <script>
            // Function to open the modal
            function openModalCustom(serviceName) {
                document.getElementById("customModal").style.display = "block";
                document.getElementById("modalTitleCustom").innerText = serviceName;
                document.getElementById("service_name_custom").value = serviceName;
            }
            // Function to close the modal
            function closeModalCustom() {
                document.getElementById("customModal").style.display = "none";
            }
            // Function to validate form (Customize as needed)
            function validateFormCustom() {
                // Add validation logic if needed
                return true;
            }
        </script>

        <script>
            // Modal handling
            function openModalCustom(serviceName, propertyType) {
                document.getElementById("modalTitleCustom").innerText =
                    propertyType; // Set the modal title to property type
                document.getElementById("service_name_custom").value =
                    serviceName; // Set the service name in the hidden field
                document.getElementById("customModal").style.display = "block";
                // Generate unique booking ID
                document.getElementById("booking_id_custom").value = generateBookingIDCustom();
            }

            function closeModalCustom() {
                document.getElementById("customModal").style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == document.getElementById("customModal")) {
                    closeModalCustom();
                }
            }
            // Form validation
            function validateFormCustom() {
                var name = document.getElementById("name_custom").value;
                var email = document.getElementById("email_custom").value;
                var mobile = document.getElementById("mobile_custom").value;
                var date = document.getElementById("booking_date_custom").value;
                if (name == "" || email == "" || mobile == "" || date == "") {
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
            function generateBookingIDCustom() {
                return 'booking_' + Date.now();
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