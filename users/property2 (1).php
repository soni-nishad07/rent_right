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

    <?php
        include('user-head.php');
    ?>

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
                        </select>

                        <select id="price_range" name="price_range">
                            <option value="">Price Range</option>
                            <option value="5000-10000" <?php echo $priceRange == '5000-10000' ? 'selected' : ''; ?>>₹5k
                                - ₹10k</option>
                            <option value="10000-30000" <?php echo $priceRange == '10000-30000' ? 'selected' : ''; ?>>
                                ₹10k - ₹30k</option>
                            <option value="30000-50000" <?php echo $priceRange == '30000-50000' ? 'selected' : ''; ?>>
                                ₹30k - ₹50k</option>
                            <option value="50000-100000" <?php echo $priceRange == '50000-100000' ? 'selected' : ''; ?>>
                                ₹50k - ₹1L</option>
                            <option value="100000-300000"
                                <?php echo $priceRange == '100000-300000' ? 'selected' : ''; ?>>₹1L - ₹3L</option>
                            <option value="300000-500000"
                                <?php echo $priceRange == '300000-500000' ? 'selected' : ''; ?>>₹3L - ₹5L</option>
                            <option value="500000-above" <?php echo $priceRange == '500000-above' ? 'selected' : ''; ?>>
                                ₹5L and above</option>

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



                <form action="" method="GET">
                    <div class="filter-details">

                        <!-- Preferred Tenants Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Preferred Tenants</div>
                            <?php
                            // Define the preferred tenants options manually
                            $tenants_options = [
                                'Family' => 'Family',
                                'Bachelor Male' => 'Bachelor Male',
                                'Bachelor Female' => 'Bachelor Female',
                                'Company' => 'Company'
                            ];

                            // Check if any preferred tenants filter is selected
                            $checked_tenants = [];
                            if (isset($_GET['preferred_tenants'])) {
                                $checked_tenants = $_GET['preferred_tenants'];
                            }

                            // Generate checkboxes for preferred tenants options
                            foreach ($tenants_options as $label => $value) {
                                ?>
                            <div class="filter-option">
                                <input type="checkbox" name="preferred_tenants[]" value="<?= $value; ?>"
                                    <?php if (in_array($value, $checked_tenants)) { echo "checked"; } ?> />
                                <span><?= $label; ?></span>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <!-- Parking Type Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Parking</div>
                            <?php
                        // Define parking options manually
                        $parking_options = [
                            'Two-Wheeler' => 'Two-Wheeler',
                            'Four-Wheeler' => 'Four-Wheeler',
                            'Show only lease properties' => 'Show-only-lease-properties',    
                        ];

                        // Check if any parking filter is selected
                        $checked_parking = [];
                        if (isset($_GET['parking'])) {
                            $checked_parking = $_GET['parking'];
                        }

                        // Generate checkboxes for parking options
                        foreach ($parking_options as $label => $value) {
                            ?>
                            <div class="filter-option">
                                <input type="checkbox" name="parking[]" value="<?= htmlspecialchars($value); ?>"
                                    <?php if (in_array($value, $checked_parking)) { echo "checked"; } ?> />
                                <span><?= htmlspecialchars($label); ?></span>
                            </div>
                            <?php
                            }
                            ?>
                        </div>


                        <!-- Bathrooms Type Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Bathrooms</div>
                            <?php
                            // Define the bathroom options manually
                            $bathroom_options = [
                                '1 or more' => 1,
                                '2 or more' => 2,
                                '3 or more' => 3
                            ];

                            // Check if any bathrooms filter is selected
                            $checked_bathrooms = [];
                            if (isset($_GET['bathrooms'])) {
                                $checked_bathrooms = $_GET['bathrooms'];
                            }

                            // Generate checkboxes for bathroom options
                            foreach ($bathroom_options as $label => $value) {
                                ?>
                            <div class="filter-option">
                                <input type="checkbox" name="bathrooms[]" value="<?= $value; ?>"
                                    <?php if (in_array($value, $checked_bathrooms)) { echo "checked"; } ?> />
                                <span><?= $label; ?></span>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <!-- Floors Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Floors</div>
                            <?php
                    // Define floor ranges manually
                        $floor_options = [
                            'Ground' => 'Ground',
                            '1 to 3' => '1 ,2 to 3',
                            '4 to 6' => '4 to 6',
                            '7 to 9' => '7 to 9',
                            '10 & above' => '10 & above'
                        ];

                        // Check if any floor filter is selected
                        $checked_floors = [];
                        if (isset($_GET['floors'])) {
                            $checked_floors = $_GET['floors'];
                        }

                        // Generate checkboxes for floor options
                        foreach ($floor_options as $label => $value) {
                            ?>
                            <div class="filter-option">
                                <input type="checkbox" name="floors[]" value="<?= $value; ?>"
                                    <?php if (in_array($value, $checked_floors)) { echo "checked"; } ?> />
                                <span><?= $label; ?></span>
                            </div>
                            <?php
                        }
                        ?>
                        </div>

                        <!-- Built-Up Area Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Built-Up Area (sq. ft)</div>
                            <div class="filter-option">
                                <label for="min_area">Min:</label>
                                <input type="number" id="min_area" name="min_area" placeholder="0"
                                    value="<?= isset($_GET['min_area']) ? $_GET['min_area'] : ''; ?>">
                            </div>
                            <div class="filter-option">
                                <label for="max_area">Max:</label>
                                <input type="number" id="max_area" name="max_area" placeholder="10,000"
                                    value="<?= isset($_GET['max_area']) ? $_GET['max_area'] : ''; ?>">
                            </div>
                        </div>

                        <!--  -->
                        <!-- Property Age Filter -->

                        <!-- Property Age Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Property Age</div>
                            <?php
                            // Define property age ranges manually with corresponding database values
                            $age_options = [
                                '1 or 2' => '<1 Year',
                                '3 or 4' => '<3 Years',
                                '5 to 10' => '<5 Years',
                                '10 to above' => '<10 Years'
                            ];

                            // Check if any property age filter is selected
                            $checked_ages = [];
                            if (isset($_GET['property_age'])) {
                                $checked_ages = $_GET['property_age'];
                            }

                            // Generate checkboxes for property age options
                            foreach ($age_options as $db_value => $label) {
                                ?>
                            <div class="filter-option">
                                <input type="checkbox" name="property_age[]" value="<?= htmlspecialchars($db_value); ?>"
                                    <?php if (in_array($db_value, $checked_ages)) { echo "checked"; } ?> />
                                <span><?= htmlspecialchars($label); ?></span>
                            </div>
                            <?php
                            }
                            ?>
                        </div>




                        <!-- Amenities Filter -->
                        <div class="filter-group">
                            <div class="filter-group-title">Amenities</div>
                            <?php
                            // Define amenities options manually
                            $amenities_options = [
                                'Gym' => 'Gym',
                                'Lift' => ' Lift',
                                'House Keeping' => 'House Keeping',
                                'Internet Service' => 'Internet Service'
                            ];

                            // Check if any amenities filter is selected
                            $checked_amenities = [];
                            if (isset($_GET['amenities'])) {
                                $checked_amenities = $_GET['amenities'];
                            }

                            // Generate checkboxes for amenities options
                            foreach ($amenities_options as $label => $value) {
                                ?>
                            <div class="filter-option">
                                <input type="checkbox" name="amenities[]" value="<?= $value; ?>"
                                    <?php if (in_array($value, $checked_amenities)) { echo "checked"; } ?> />
                                <span><?= $label; ?></span>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary text-white btn-sm float-end"
                        style="margin:20px;">Search</button>
                </form>

            </div>

            <div class="filters-btn2">
                <a href="property">Less Filters</a>
            </div>

        </div>

        <section class="locations-property">
            <div class="location-tags">
                <form action="" method="post" class="form-group location-form">
                    <i class="fa-solid fa-location-dot location-icons"></i>
                    <input type="search" name="location" placeholder="Type Your Location" id="location-search"
                        class="form-control locationsearch" value="<?php echo htmlspecialchars($location); ?>">
                    <button type="button" class="btn" onclick="window.location.href='property2.php'">
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
        </section>

        <?php
include('../connection.php');


// Initialize search parameters
$location = isset($_POST['location']) ? $_POST['location'] : '';
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
if (!empty($location)) {
    $where_clauses[] = "city LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
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

        <?php
include('../connection.php');

// Initialize search parameters
$location = isset($_POST['location']) ? $_POST['location'] : '';
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
if (!empty($location)) {
    $where_clauses[] = "city LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
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
                                    <div class="detail-item">Location- <?php echo $row['city']; ?></div>
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
                <h1 class="booking_for-custom"> Booking for: <span id="modalTitleCustom"></span></h1>
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
                        <textarea name="address" rows="3" cols="100" id="address_custom" placeholder="Enter Address"
                            required></textarea>
                    </div>
                    
                    <!-- Add more payment options here if needed -->
                     
                    <!-- <div class="input-group-custom">
                        <select class="form-select-custom" aria-label="Default select" id="payment_mode_custom"
                            name="payment_mode" required>
                            <option value="" disabled selected>----Select Payment Mode---</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div> -->

                    <!-- <div class="input-group-custom">
                        <input type="date" id="booking_date_custom" name="booking_date" required>
                    </div> -->
                    <div class="input-group-custom">
                        <!-- <span>Provide Date For Booking!</span> -->
                    </div>
                    <button type="submit" name="book-services" class="book-services-custom">Book Now</button>
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
            var address = document.getElementById("address_custom").value;
            // var paymentMode = document.getElementById("payment_mode_custom").value;
            // var date = document.getElementById("booking_date_custom").value;
            if (name == "" || email == "" || mobile == "" || address == "" ) {
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
include('../copyright.php');
?>

</body>

</html>