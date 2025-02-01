<?php
include('../connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login');
    exit();
}




// // Fetch commercial property types
// $sql_commercial = "SELECT DISTINCT property_type FROM category WHERE property_choose LIKE '%Commercial%'";
// $commercial_type_result = $conn->query($sql_commercial);

// // Fetch general property types
// $property_type_query = "SELECT DISTINCT property_type FROM category WHERE property_choose LIKE '%Buy%'";
// $property_type_result = $conn->query($property_type_query);

// // Fetch BHK types
// $bhk_query = "SELECT DISTINCT bhk_type FROM category WHERE bhk_type IS NOT NULL";
// $bhk_result = $conn->query($bhk_query);



// Fetch commercial property types
$sql_commercial = "SELECT DISTINCT property_type FROM category WHERE property_choose LIKE '%Commercial%'";
$commercial_type_result = $conn->query($sql_commercial);

// Fetch general property types
$property_type_query = "SELECT DISTINCT property_type FROM category WHERE property_choose LIKE '%Buy%'";
$property_type_result = $conn->query($property_type_query);

// Combine both property types (avoiding duplicates)
$property_types = [];
if ($property_type_result->num_rows > 0) {
    while ($row = $property_type_result->fetch_assoc()) {
        $property_types[$row['property_type']] = $row['property_type']; // Add to array, using the value as key to avoid duplicates
    }
}
if ($commercial_type_result->num_rows > 0) {
    while ($row = $commercial_type_result->fetch_assoc()) {
        $property_types[$row['property_type']] = $row['property_type']; // Add commercial types to the same array
    }
}

// Fetch BHK types (not used for property type, but can be used for another select dropdown)
$bhk_query = "SELECT DISTINCT bhk_type FROM category WHERE bhk_type IS NOT NULL";
$bhk_result = $conn->query($bhk_query);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Property </title>
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"></script>
    <!-- <script>
        function initializeAutocomplete() {
            var input = document.getElementById('city');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }
        google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
    </script> -->

    <script>
        let selectedLocalities = new Set();

        function initializeAutocomplete() {
            var input = document.getElementById('city');
            var autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['(cities)'],
                componentRestrictions: {
                    country: 'in'
                }
            });

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                document.getElementById('city').value = place.name;

                // Extract state information
                let state = '';
                place.address_components.forEach((component) => {
                    if (component.types.includes('administrative_area_level_1')) {
                        state = component.long_name;
                    }
                });
                document.getElementById('state').value = state;

                const areaInput = document.getElementById('area');
                const areaAutocomplete = new google.maps.places.Autocomplete(areaInput, {
                    types: ['geocode'],
                    componentRestrictions: {
                        country: 'in'
                    },
                    bounds: place.geometry.viewport
                });

                areaAutocomplete.addListener('place_changed', function() {
                    var areaPlace = areaAutocomplete.getPlace();
                    if (!areaPlace.geometry) {
                        return;
                    }

                    let fullAddress = [];
                    areaPlace.address_components.forEach((component) => {
                        if (component.types.includes('sublocality_level_1') || component.types.includes('locality') || component.types.includes('administrative_area_level_2')) {
                            fullAddress.push(component.long_name);
                        }
                    });

                    const addressStr = fullAddress.join(', ');
                    if (!selectedLocalities.has(addressStr)) {
                        selectedLocalities.add(addressStr);
                        displaySelectedLocalities();
                    }
                });
            });
        }

        function displaySelectedLocalities() {
            const selectedAreaDiv = document.getElementById('selectedLocalitiesContainer');
            selectedAreaDiv.innerHTML = '';
            selectedLocalities.forEach(locality => {
                selectedAreaDiv.innerHTML += `<span class="selected-locality-item">${locality}
                <span onclick="removeLocality('${locality}')"><svg class="mr-0.2p" viewBox="0 0 24 24" color="#fff" height="10" width="10" style="width: 10px; height: 10px; margin: 0px;"><path fill="#fff" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"></path></svg></span></span>`;
            });
        }

        function removeLocality(locality) {
            selectedLocalities.delete(locality);
            displaySelectedLocalities();
        }

        google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
    </script>

    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            margin-top: -5px;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }
    </style>

    <?php
    include('../links.php');
    include('user-head.php');
    // include('../head.php'); 
    ?>

</head>


<body>

    <div class="form-container  post_container">
        <div class="step-indicator">
            <div class="step active" data-step="1">Property Details</div>
            <div class="step" data-step="2">Locality Details</div>
            <div class="step" data-step="3">Rental Details</div>
            <div class="step" data-step="4">Amenities</div>
            <div class="step" data-step="5">Gallery</div>
            <div class="step" data-step="6">Schedule</div>
        </div>

        <form id="propertyForm" method="post" action="post_insert.php" enctype="multipart/form-data">
            <!-- Step 1 -->
            <div class="form-section active" data-step="1">
                <h2>Property Details</h2>
                <!-- Owner/Agent Selection -->
                <div class="form-control">
                    <label for="owner-agent-select">Select Owner or Agent:</label>
                    <select id="owner-agent-select" name="owner_agent_type" required onchange="toggleBhkOptions()">
                        <option value="">--Select--</option>
                        <option value="Owner">Owner</option>
                        <option value="Agent">Agent</option>
                    </select>
                    <small class="error-message" id="owner-agent-error" style="color: red; display: none;">Please select
                        an option.</small>
                </div>




                <!-- Dynamic BHK Selection for Owner -->
                <div id="owner-options" style="display: none;" class="form-control">
                    <label for="owner-bhk-select">BHK Type for Owner:</label>
                    <select id="owner-bhk-select" name="owner_bhk_type">
                        <option value="">Select BHK Type</option>
                        <?php
                        if ($bhk_result->num_rows > 0) {
                            while ($row = $bhk_result->fetch_assoc()) {
                                $bhk_type = htmlspecialchars($row['bhk_type']);
                                if (!empty($bhk_type)) {
                                    echo "<option value='$bhk_type'>$bhk_type</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Dynamic BHK Selection for Agent -->
                <div id="agent-options" style="display: none;" class="form-control">
                    <label for="agent-bhk-select">BHK Type for Agent:</label>
                    <select id="agent-bhk-select" name="agent_bhk_type">
                        <option value="">Select BHK Type</option>
                        <?php
                        // Reset BHK result pointer
                        $bhk_result->data_seek(0);
                        if ($bhk_result->num_rows > 0) {
                            while ($row = $bhk_result->fetch_assoc()) {
                                $bhk_type = htmlspecialchars($row['bhk_type']);
                                if (!empty($bhk_type)) {
                                    echo "<option value='$bhk_type'>$bhk_type</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>



                <!-- Dynamic Property Type Selection -->
                <!-- Dynamic Property Type Selection -->
                <div class="form-control">
                    <label for="propertyType">Property Type:</label>
                    <select id="propertyType" name="property_type" required>
                        <option value="">--Select Property Type--</option>
                        <?php
                        foreach ($property_types as $property_type) {
                            $type = htmlspecialchars($property_type);
                            if (!empty($type)) {
                                echo "<option value='$type'>$type</option>";
                            }
                        }
                        ?>
                    </select>
                </div>


                <!-- Dynamic Property Type Selection -->
                <!-- <select name="property_type"  class="form-control" required>
                    <option value="">Select Property Type</option>
                    <?php
                    if ($property_type_result->num_rows > 0) {
                        while ($row = $property_type_result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['property_type']) . "'>" . htmlspecialchars($row['property_type']) . "</option>";
                        }
                    }
                    ?>
                </select> -->

                <!-- Dynamic Commercial Type Selection -->
                <!-- <select name="commercial_type" class="form-control"  required>
                    <option value="">Select Commercial Type</option>
                    <?php
                    if ($commercial_type_result->num_rows > 0) {
                        while ($row = $commercial_type_result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['property_type']) . "'>" . htmlspecialchars($row['property_type']) . "</option>";
                        }
                    }
                    ?>
                </select> -->


                <!-- BHK Options for Owner and Agent -->
                <!-- <div class="form-control" id="owner-options" style="display: none;">
                    <label for="owner-bhk-select">BHK Type for Owner:</label>
                    <select id="owner-bhk-select" name="owner_bhk_type">
                        <option value="">Select BHK Type for Owner</option>
                        <option value="1BHK">1 BHK</option>
                        <option value="2BHK">2 BHK</option>
                        <option value="3BHK">3 BHK</option>
                        <option value="4BHK">4 BHK</option>
                        <option value="5BHK">5 BHK</option>
                        <option value="IndependentHouse">Independent House</option>
                        <option value="1RK">1RK</option>
                        <option value="CommercialSpace">Commercial Space</option>
                        <option value="Land">Land</option>
                        <option value="CompleteBuilding">Complete Building</option>
                        <option value="Bungalow">Bungalow</option>
                        <option value="Villa">Villa</option>
                    </select>
                </div>

                <div class="form-control" id="agent-options" style="display: none;">
                    <label for="agent-bhk-select">BHK Type for Agent:</label>
                    <select id="agent-bhk-select" name="agent_bhk_type">
                        <option value="">Select BHK Type for Agent</option>
                        <option value="1BHK">1 BHK</option>
                        <option value="2BHK">2 BHK</option>
                        <option value="3BHK">3 BHK</option>
                        <option value="4BHK">4 BHK</option>
                        <option value="5BHK">5 BHK</option>
                        <option value="IndependentHouse">Independent House</option>
                        <option value="1RK">1RK</option>
                        <option value="CommercialSpace">Commercial Space</option>
                        <option value="Land">Land</option>
                        <option value="CompleteBuilding">Complete Building</option>
                        <option value="Bungalow">Bungalow</option>
                        <option value="Villa">Villa</option>
                    </select>
                </div> -->


                <!-- Property Type Selection -->
                <!-- <div class="form-control">
                    <label for="propertyType">Property Type:</label>
                    <select id="propertyType" name="property_type" required>
                        <option value="">--Select Property Type--</option>
                        <option value="Flat">Flat</option>
                        <option value="Building">Building</option>
                        <option value="Site">Site</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Villa">Villa</option>
                        <option value="Techpark">Techpark</option>
                        <option value="CommercialFloor ">Commercial Floor </option>
                        <option value="CommercialBuilding">Commercial Building</option>
                    </select>
                </div> -->

                <!-- Build Up Area -->
                <div class="form-control">
                    <label for="build_up_area">Build Up Area (sqft):</label>
                    <input type="number" id="build_up_area" name="build_up_area" placeholder="Build Up Area" required>
                </div>
                <!-- Property Age -->
                <div class="form-control">
                    <label for="property_age">Property Age:</label>
                    <input type="text" id="property_age" name="property_age" placeholder="Property Age" required>
                </div>
                <!-- Floor -->
                <div class="form-control">
                    <label for="floor">Floor:</label>
                    <input type="number" id="floor" name="floor" placeholder="Floor" required>
                </div>
                <!-- Total Floor -->
                <div class="form-control">
                    <label for="total_floor">Total Floor:</label>
                    <input type="number" id="total_floor" name="total_floor" placeholder="Total Floor" required>
                </div>
            </div>



            <!-- Step 2 -->
            <!-- <div class="form-section" data-step="2">
                <h2>Locality Details</h2>
                <div class="form-control">
                    <label for="city">Location:</label>
                    <input type="text" id="city" name="city" class="location" placeholder="City/Bangalore" required>
                </div>
            </div> -->



            <!-- Step 2 -->
            <!-- <div class="form-section" data-step="2">
                <h2>Locality Details</h2>

                <div class="form-control">
                    <label for="area">Area:</label>
                    <input type="text" id="area" name="area" class="area" placeholder="City/Bangalore" required>
                </div>

                <div class="form-control">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="City">
                </div>

                <div class="form-control">
                    <label for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value="" disabled selected>Select State</option>
                    </select>
                </div>
            </div> -->



            <!-- Step 2 -->
            <div class="form-section" data-step="2">
                <h2>Locality Details</h2>

                <!-- City -->
                <div class="form-control">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="City" required>
                </div>

                <!-- State Dropdown -->
                <div class="form-control">
                    <label for="state">State:</label>
                    <input type="text" id="state" name="state" placeholder="State" readonly>
                </div>

                <!-- Area -->
                <div class="form-control">
                    <label for="area">Area:</label>
                    <input type="text" id="area" name="area" placeholder="Search up to localities or landmarks" required>
                    <!-- <div id="selectedLocalitiesContainer"></div> -->
                </div>
            </div>




            <!-- Step 3 -->
            <div class="form-section" data-step="3">
                <h2>Rental Details</h2>

                <!-- Existing Rent and Deposit Fields -->
                <div class="form-group">
                    <label>Property Available For:</label>
                    <label class="checkbox-label"><input type="checkbox" name="available_for[]" value="Rent">
                        Rent</label>
                    <label class="checkbox-label"><input type="checkbox" name="available_for[]" value="Sale">
                        Sale</label>
                    <label class="checkbox-label"><input type="checkbox" name="available_for[]" value="Only Lease"> Only
                        Lease</label>
                </div>

                <div class="form-group inline-group">

                    <div class="inline-item">
                        <label for="rent">Rent:</label>
                        <input type="number" name="expected_rent" placeholder="Expected Rent" required>
                        <span>/month</span>
                    </div>

                    <!-- <div class="inline-item">
                        <label for="rent">Rent:</label>
                        <select name="expected_rent" required>
                            <option value="">Select Expected Rent</option>
                            <option value="5000-10000">5,000 - 10,000</option>
                            <option value="10000-30000">10,000 - 30,000</option>
                            <option value="30000-50000">30,000 - 50,000</option>
                            <option value="50000-100000">50,000 - 100,000</option>
                            <option value="100000-150000">100,000 - 150,000</option>
                            <option value="150000-200000">150,000 - 200,000</option>
                            <option value="200000-250000">200,000 - 250,000</option>
                            <option value="250000-300000">250,000 - 300,000</option>
                            <option value="300000-350000">300,000 - 350,000</option>
                            <option value="350000-400000">350,000 - 400,000</option>
                            <option value="400000-450000">400,000 - 450,000</option>
                            <option value="450000-480000">450,000 - 480,000</option>
                            <option value="480000-500000">480,000 - 500,000</option>
                            <option value="500000-above">500,000 - Above</option>
                        </select>
                        <span style="margin-right:20px;">/month</span>
                    </div> -->

                    <!-- <div class="inline-item">
                        <label for="expected_rent">Rent:</label>
                        <select name="expected_rent" required>
                            <option value="">Select Expected Rent</option>
                            <?php
                            $sql_rent = "SELECT DISTINCT expected_rent_from, expected_rent_to FROM category WHERE expected_rent_from IS NOT NULL AND expected_rent_to IS NOT NULL";
                            $rent_result = $conn->query($sql_rent);
                            if ($rent_result->num_rows > 0) {
                                while ($row = $rent_result->fetch_assoc()) {
                                    echo '<option value="' . $row['expected_rent_from'] . '-' . $row['expected_rent_to'] . '">'
                                        . number_format($row['expected_rent_from']) . ' - ' . number_format($row['expected_rent_to']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <span style="margin-right:20px;">/month</span>
                    </div> -->


                    <!-- <div class="inline-item">
                        <label for="expected_rent">Rent:</label>
                        <select name="expected_rent" required>
                            <option value="">Select Expected Rent</option>
                            <?php
                            // Fetch distinct rent ranges from the database (including commercial rent)
                            $sql_rent = "
                            SELECT DISTINCT expected_rent_from AS rent_from, expected_rent_to AS rent_to 
                            FROM category 
                            WHERE expected_rent_from IS NOT NULL AND expected_rent_to IS NOT NULL
                            UNION
                            SELECT DISTINCT commercial_rent_from AS rent_from, commercial_rent_to AS rent_to 
                            FROM category 
                            WHERE commercial_rent_from IS NOT NULL AND commercial_rent_to IS NOT NULL
                        ";
                            $rent_result = $conn->query($sql_rent);

                            if ($rent_result->num_rows > 0) {
                                while ($row = $rent_result->fetch_assoc()) {
                                    echo '<option value="' . $row['rent_from'] . '-' . $row['rent_to'] . '">'
                                        . number_format($row['rent_from']) . ' - ' . number_format($row['rent_to']) . '</option>';
                                }
                            }
                            ?>

                        </select>
                        <span style="margin-right:20px;">/month</span>
                    </div> -->




                    <!-- <div class="inline-item">
                        <label for="expected_rent">Rent:</label>
                        <select name="expected_rent" required>
                            <option value="">Select Expected Rent</option>
                            <?php
                            // Fetch distinct rent ranges from the database (including commercial rent and deposit)
                            $sql_rent_deposit = "
                        SELECT DISTINCT expected_rent_from AS rent_from, expected_rent_to AS rent_to 
                        FROM category 
                        WHERE expected_rent_from IS NOT NULL AND expected_rent_to IS NOT NULL
                        UNION
                        SELECT DISTINCT commercial_rent_from AS rent_from, commercial_rent_to AS rent_to 
                        FROM category 
                        WHERE commercial_rent_from IS NOT NULL AND commercial_rent_to IS NOT NULL
                        UNION
                        SELECT DISTINCT expected_deposit_from AS rent_from, expected_deposit_to AS rent_to 
                        FROM category 
                        WHERE expected_deposit_from IS NOT NULL AND expected_deposit_to IS NOT NULL
                        ";
                            $rent_deposit_result = $conn->query($sql_rent_deposit);

                            if ($rent_deposit_result->num_rows > 0) {
                                while ($row = $rent_deposit_result->fetch_assoc()) {
                                    echo '<option value="' . $row['rent_from'] . '-' . $row['rent_to'] . '">'
                                        . number_format($row['rent_from']) . ' - ' . number_format($row['rent_to']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <span style="margin-right:20px;">/month</span>
                    </div> -->



                    <!-- <div class="inline-item">
                        <label for="deposit">Deposit:</label>
                        <input type="number" name="expected_deposit" placeholder="Expected Deposit" required>
                    </div> -->


                    <!-- <div class="inline-item">
                        <label for="expected_deposit">Deposit:</label>
                        <select name="expected_deposit" required>
                            <option value="">Select Expected Deposit</option>
                            <option value="3000000-3500000">30L - 35L</option>
                            <option value="3500000-4000000">35L - 40L</option>
                            <option value="4000000-4500000">40L - 45L</option>
                            <option value="4500000-5000000">45L - 50L</option>
                            <option value="5000000-5500000">50L - 55L</option>
                            <option value="5500000-6000000">55L - 60L</option>
                            <option value="6000000-6500000">60L - 65L</option>
                            <option value="6500000-7000000">65L - 70L</option>
                            <option value="7000000-7500000">70L - 75L</option>
                            <option value="7500000-8000000">75L - 80L</option>
                            <option value="8000000-8500000">80L - 85L</option>
                            <option value="8500000-9000000">85L - 90L</option>
                            <option value="9000000-9500000">90L - 95L</option>
                            <option value="9500000-10000000">95L - 1Cr</option>
                            <option value="10000000-15000000">1Cr - 1.5Cr</option>
                            <option value="15000000-20000000">1.5Cr - 2Cr</option>
                            <option value="20000000-30000000">2Cr - 3Cr</option>
                            <option value="30000000-40000000">3Cr - 4Cr</option>
                            <option value="40000000-50000000">4Cr - 5Cr</option>
                            <option value="50000000-above">5Cr - Above</option>
                        </select>
                    </div> -->


                    <div class="inline-item">
                        <label for="deposit">Deposit:</label>
                        <input type="text" name="expected_deposit" placeholder="Expected Deposit" required>
                    </div>

                    <!-- <div class="inline-item">
                        <label for="expected_deposit">Deposit:</label>
                        <select name="expected_deposit" required>
                            <option value="">Select Expected Deposit</option>
                            <?php
                            // Fetch distinct deposit ranges from the database
                            $deposit_query = "SELECT DISTINCT expected_deposit_from, expected_deposit_to FROM category WHERE expected_deposit_from IS NOT NULL AND expected_deposit_to IS NOT NULL";
                            $deposit_result = $conn->query($deposit_query);
                            if ($deposit_result->num_rows > 0) {
                                while ($row = $deposit_result->fetch_assoc()) {
                                    echo '<option value="' . $row['expected_deposit_from'] . '-' . $row['expected_deposit_to'] . '">'
                                        . number_format($row['expected_deposit_from']) . ' - ' . number_format($row['expected_deposit_to']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div> -->

                </div>

                <!-- <div class="form-group inline-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="maintenance" value="Maintenance Included"> Maintenance Included
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="maintenance" value="Maintenance Extra"> Maintenance Extra
                    </label>
                </div> -->

                <div class="form-group inline-group">
                    <label class="checkbox-label">
                        <input type="radio" name="maintenance" value="Maintenance Included"> Maintenance Included
                    </label>
                    <label class="checkbox-label">
                        <input type="radio" name="maintenance" value="Maintenance Extra"> Maintenance Extra
                    </label>
                </div>

                <div class="form-group">
                    <label for="available_from">Available from:</label>
                    <input type="date" name="available_from" id="available_from">
                </div>

                <div class="form-group">
                    <label>Preferred Tenants:</label>
                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]" value="Anyone">
                        Anyone</label>
                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]" value="Family">
                        Family</label>
                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                            value="Bachelor Female"> Bachelor Female</label>
                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                            value="Bachelor Male"> Bachelor Male</label>
                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]" value="Company">
                        Company</label>
                </div>

                <div class="form-group inline-group">
                    <div class="inline-item">
                        <select name="furnishing">
                            <option value="">--Select Furnishing--</option>
                            <option value="Unfurnished">Unfurnished</option>
                            <option value="Semi-Furnished">Semi-Furnished</option>
                            <option value="Fully-Furnished">Fully-Furnished</option>
                        </select>
                    </div>
                    <div class="inline-item">
                        <select name="parking" id="parking">
                            <option value="">--Select Parking--</option>
                            <option value="Two-Wheeler">Two-Wheeler</option>
                            <option value="Four-Wheeler">Four-Wheeler</option>
                        </select>
                    </div>
                </div>

                <div class="form-group textarea-group">
                    <label for="description">Property Description:</label>
                    <textarea name="description" id="description"
                        placeholder="Write a description about your property if needed."></textarea>
                </div>
            </div>



            <!-- Step 4 -->
            <div class="form-section" data-step="4">
                <h2>Amenities and Specifications</h2>

                <!-- Bathroom and Balcony Section -->
                <div class="amentities_row">
                    <div class="bathroom">
                        <p>Bathroom(s)</p>
                        <div class="quantity">
                            <a href="#" class="quantity__minus"><span>-</span></a>
                            <input name="bathrooms" type="text" class="quantity__input" value="1">
                            <a href="#" class="quantity__plus"><span>+</span></a>
                        </div>
                    </div>

                    <div class="balcony">
                        <p>Balcony</p>
                        <div class="quantity2">
                            <a href="#" class="quantity__minus2"><span>-</span></a>
                            <input name="balcony" type="text" class="quantity__input2" value="1">
                            <a href="#" class="quantity__plus2"><span>+</span></a>
                        </div>
                    </div>

                    <!-- Water Supply Selection -->
                    <div class="water">
                        <select name="water_supply" id="water-supply" required>
                            <option value="">Water Supply</option>
                            <option value="Municipal">Municipal</option>
                            <option value="Borewell">Borewell</option>
                            <option value="Both (Municipal + Borewell)">Both (Municipal + Borewell)</option>
                        </select>
                    </div>
                </div>

                <!-- Amenities Selection -->
                <div class="amentities_row2">
                    <h2>Select the available amenities</h2>

                    <div class="amentities">
                        <div class="chechboxs">
                            <div class="form-check">
                                <!-- <input class="form-check-input" type="checkbox" value="Gym" name="amenities[]" checked> -->
                                <input class="form-check-input" type="checkbox" value="Gym" name="amenities[]">
                                <label class="form-check-label">Gym</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Servant Room" name="amenities[]">
                                <label class="form-check-label">Servant Room</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Kids Play Area"
                                    name="amenities[]">
                                <label class="form-check-label">Kids Play Area</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Fire Safety" name="amenities[]">
                                <label class="form-check-label">Fire Safety</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Garden Area" name="amenities[]">
                                <label class="form-check-label">Garden Area</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Yoga Centre" name="amenities[]">
                                <label class="form-check-label">Yoga Centre</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Car Parking"
                                    name="amenities[]">
                                <label class="form-check-label">Car Parking</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="RO"
                                    name="amenities[]">
                                <label class="form-check-label">RO</label>
                            </div>


                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Air Conditioner"
                                    name="amenities[]">
                                <label class="form-check-label">Air Conditioner</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="King Size Bed"
                                    name="amenities[]">
                                <label class="form-check-label">King Size Bed</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Tea Table"
                                    name="amenities[]">
                                <label class="form-check-label">Tea Table</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Microwave Oven"
                                    name="amenities[]">
                                <label class="form-check-label">Microwave Oven</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Study Table"
                                    name="amenities[]">
                                <label class="form-check-label">Study Table</label>
                            </div>

                        </div>



                        <div class="chechboxs">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Lift" name="amenities[]">
                                <label class="form-check-label">Lift</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Visitor Parking"
                                    name="amenities[]">
                                <label class="form-check-label">Visitor Parking</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Power Backup" name="amenities[]">
                                <label class="form-check-label">Power Backup</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="House Keeping"
                                    name="amenities[]">
                                <label class="form-check-label">House Keeping</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Party Hall" name="amenities[]">
                                <label class="form-check-label">Party Hall</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Security" name="amenities[]">
                                <label class="form-check-label">Security</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Bike Parking"
                                    name="amenities[]">
                                <label class="form-check-label">Bike Parking</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Refrigerator"
                                    name="amenities[]">
                                <label class="form-check-label">Refrigerator</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Sofa"
                                    name="amenities[]">
                                <label class="form-check-label">Sofa</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Queen Size Bed"
                                    name="amenities[]">
                                <label class="form-check-label">Queen Size Bed</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Geyser"
                                    name="amenities[]">
                                <label class="form-check-label">Geyser</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Cupboards"
                                    name="amenities[]">
                                <label class="form-check-label">Cupboards</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="utility"
                                    name="amenities[]">
                                <label class="form-check-label">Utility</label>
                            </div>

                        </div>



                        <div class="chechboxs">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Air Conditioner"
                                    name="amenities[]">
                                <label class="form-check-label">Air Conditioner</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Club House" name="amenities[]">
                                <label class="form-check-label">Club House</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Internet Service"
                                    name="amenities[]">
                                <label class="form-check-label">Internet Service</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="CCTV" name="amenities[]">
                                <label class="form-check-label">CCTV</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Swimming Pool"
                                    name="amenities[]">
                                <label class="form-check-label">Swimming Pool</label>
                            </div>

                            <!-- added amenities -->

                            <!-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Utility"
                                    name="amenities[]">
                                <label class="form-check-label">Utility</label>
                            </div> -->

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Shoe Rack"
                                    name="amenities[]">
                                <label class="form-check-label">Shoe Rack</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Television"
                                    name="amenities[]">
                                <label class="form-check-label">Television</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Washing Machine"
                                    name="amenities[]">
                                <label class="form-check-label">Washing Machine</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Mattresses"
                                    name="amenities[]">
                                <label class="form-check-label">Mattresses</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Single Bed"
                                    name="amenities[]">
                                <label class="form-check-label">Single Bed</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Kitchen Appliances"
                                    name="amenities[]">
                                <label class="form-check-label">Kitchen Appliances</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Wardrobes"
                                    name="amenities[]">
                                <label class="form-check-label">Wardrobes</label>
                            </div>

                        </div>


                    </div>
                </div>
            </div>



            <!-- Step 5 -->
            <div class="form-section" data-step="5">
                <h2>Upload Documents</h2>
                <div class="upload_img">
                    <label for="file_upload">Upload Images:</label>
                    <input type="file" name="file_upload[]" id="file_upload" accept="image/png, image/jpg, image/jpeg"
                        class="form-control" multiple required>
                    <p id="file_count">No files selected</p>
                </div>
            </div>



            <!-- Step 6 -->
            <div class="form-section" data-step="6">
                <!-- Availability Section -->
                <div class="availability-container">
                    <div class="availability">
                        <b>
                            <p>Availability</p>
                        </b>
                        <br />
                        <button type="button" class="availability-btn" data-value="Everyday (Mon-Sun)">Everyday
                            (Mon-Sun)</button>
                        <button type="button" class="availability-btn" data-value="Weekday (Mon-Fri)">Weekday
                            (Mon-Fri)</button>
                        <button type="button" class="availability-btn" data-value="Weekend (Sat-Sun)">Weekend
                            (Sat-Sun)</button>
                        <input type="hidden" name="availability" id="availability" />
                    </div>

                    <!-- Time Schedule Section -->
                    <div class="schedule-heading">
                        <p>Select Time Schedule</p>
                    </div>
                    <div class="time-schedule">
                        <label for="Start_Time">Start Time
                            <input type="time" placeholder="Start Time" name="start_time" id="start_time">
                        </label>
                        <label for="End_Time">End Time
                            <input type="time" placeholder="End Time" name="end_time" id="end_time">
                        </label>
                    </div>

                    <!-- Checkbox for "Available All Day" -->
                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" name="available_all" id="available_all"> Available All Day
                        </label>
                    </div>
                </div>
            </div>


            <div class="navigation-buttons">
                <button type="button" id="prevBtn" onclick="navigateSteps(-1)" disabled>Back</button>
                <button type="button" id="nextBtn" onclick="navigateSteps(1)">Save & Continue</button>
                <button type="submit" id="submitBtn" style="display: none;">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>



    <!-- <script>
    function initAutocomplete() {
        const input = document.getElementById("city");
        const options = {
            types: ['(cities)'], 
            componentRestrictions: { country: 'IN' } 
        };
        new google.maps.places.Autocomplete(input, options);
    }
    document.addEventListener("DOMContentLoaded", function() {
        initAutocomplete();
    });
</script> -->




    <script>
        const indianStates = [
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana",
            "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana",
            "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands", "Chandigarh",
            "Dadra and Nagar Haveli and Daman and Diu", "Lakshadweep", "Delhi", "Puducherry"
        ];


        function populateStateDropdown() {
            const stateDropdown = document.getElementById('state');
            indianStates.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateDropdown.appendChild(option);
            });
        }

        function initAutocomplete() {
            // Populate the state dropdown initially
            populateStateDropdown();

            // Initialize Google Places Autocomplete for the area input
            const areaInput = document.getElementById('area');
            const autocomplete = new google.maps.places.Autocomplete(areaInput, {
                types: ['geocode'],
                componentRestrictions: {
                    country: 'in'
                }
            });

            // Add listener to fetch and autofill details
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();

                if (place && place.address_components) {
                    let city = '';
                    let state = '';

                    place.address_components.forEach((component) => {
                        const types = component.types;

                        if (types.includes('locality')) {
                            city = component.long_name; // City
                        } else if (types.includes('administrative_area_level_1')) {
                            state = component.long_name; // State
                        }
                    });
                    // Autofill the city field
                    if (city) {
                        document.getElementById('city').value = city;
                    }
                    // Autofill the state dropdown
                    const stateDropdown = document.getElementById('state');
                    if (state) {
                        for (let i = 0; i < stateDropdown.options.length; i++) {
                            if (stateDropdown.options[i].value === state) {
                                stateDropdown.selectedIndex = i;
                                break;
                            }
                        }
                    }
                }
            });
        }
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>





    <script src="../js/post.js"></script>
    <script src="../js/script.js"></script>

</body>

</html>