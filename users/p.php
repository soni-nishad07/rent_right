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
             
                <!-- Total Floor -->
                <div class="form-control">
                    <label for="total_floor">Total Floor:</label>
                    <input type="number" id="total_floor" name="total_floor" placeholder="Total Floor" required>
                </div>
            </div>


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

            </div>




            <!-- Step 3 -->
            <div class="form-section" data-step="3">
                <h2>Rental Details</h2>

 
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