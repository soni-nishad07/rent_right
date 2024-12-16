<?php
include('../connection.php');
include('session_check.php');

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM properties WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $property_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
    } else {
        die('Property not found.');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <?php include('../links.php'); ?>
    <script src="../js/bootstrap.bundle.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"
        async defer></script>
    <script>
        function initializeAutocomplete() {
            var input = document.getElementById('city');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeAutocomplete();
        });
    </script>

</head>

<body>

    <?php include('user-head.php');  ?>

    <div class="container">
        <div class="property-card-heading">
            <h4>Update Property List</h4>
        </div>

        <div class="update_property">
            <form method="POST" action="upcode_property_list.php?id=<?php echo htmlspecialchars($property_id); ?>"
                enctype="multipart/form-data">

                <div class="form-group">
                    <label for="available_for">Property Available For</label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="available_for[]" value="Rent"
                            <?php echo (strpos($property['available_for'], 'Rent') !== false) ? 'checked' : ''; ?>> Rent
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="available_for[]" value="Sale"
                            <?php echo (strpos($property['available_for'], 'Sale') !== false) ? 'checked' : ''; ?>> Sale
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="available_for[]" value="Only Lease"
                            <?php echo (strpos($property['available_for'], 'Only Lease') !== false) ? 'checked' : ''; ?>>
                        Only Lease
                    </label>
                </div>



                <div class="form-group">
                    <label for="property_type">Property Type</label>
                    <select name="property_type" id="property-type" required>
                        <option value="">-----Property Type-----</option>
                        <option value="Flat" <?php echo ($property['property_type'] == 'Flat') ? 'selected' : ''; ?>>
                            Flat</option>
                        <option value="Building"
                            <?php echo ($property['property_type'] == 'Building') ? 'selected' : ''; ?>>Building
                        </option>
                        <option value="Site" <?php echo ($property['property_type'] == 'Site') ? 'selected' : ''; ?>>
                            Site</option>
                        <option value="Commercial"
                            <?php echo ($property['property_type'] == 'Commercial') ? 'selected' : ''; ?>>Commercial
                        </option>
                        <option value="Villa" <?php echo ($property['property_type'] == 'Villa') ? 'selected' : ''; ?>>
                            Villa</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="available_from">Available From</label>
                    <input type="date" name="available_from"
                        value="<?php echo htmlspecialchars($property['available_from']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="bhk-type">BHK Type</label>
                    <select id="bhk-type" name="bhk_type" required>
                        <option value="">--Select BHK Type--</option>
                        <option value="1BHK" <?php echo ($property['bhk_type'] == '1BHK') ? 'selected' : ''; ?>>1 BHK
                        </option>
                        <option value="2BHK" <?php echo ($property['bhk_type'] == '2BHK') ? 'selected' : ''; ?>>2 BHK
                        </option>
                        <option value="3BHK" <?php echo ($property['bhk_type'] == '3BHK') ? 'selected' : ''; ?>>3 BHK
                        </option>
                        <option value="4BHK" <?php echo ($property['bhk_type'] == '4BHK') ? 'selected' : ''; ?>>4 BHK
                        </option>
                        <option value="5BHK" <?php echo ($property['bhk_type'] == '5BHK') ? 'selected' : ''; ?>>5 BHK
                        </option>
                        <option value="IndependentHouse"
                            <?php echo ($property['bhk_type'] == 'IndependentHouse') ? 'selected' : ''; ?>>Independent
                            House</option>
                        <option value="1RK"
                            <?php echo ($property['bhk_type'] == 'RK') ? 'selected' : ''; ?>>RK</option>
                        <option value="CommercialSpace"
                            <?php echo ($property['bhk_type'] == 'CommercialSpace') ? 'selected' : ''; ?>>Commercial Space</option>
                        <option value="Land"
                            <?php echo ($property['bhk_type'] == 'Land') ? 'selected' : ''; ?>>Land</option>
                        <option value="CompleteBuilding"
                            <?php echo ($property['bhk_type'] == 'CompleteBuilding') ? 'selected' : ''; ?>>CompleteBuilding</option>
                        <option value="Bungalow"
                            <?php echo ($property['bhk_type'] == 'Bungalow') ? 'selected' : ''; ?>>Bungalow</option>
                        <option value="Villa"
                            <?php echo ($property['bhk_type'] == 'Villa') ? 'selected' : ''; ?>>Villa</option>

                    </select>
                </div>


                <div class="form-group">
                    <label for="furnishing">Furnishing</label>
                    <select name="furnishing" id="furnishing" required>
                        <option value="">--Select Furnishing--</option>
                        <option value="Unfurnished"
                            <?php echo ($property['furnishing'] == 'Unfurnished') ? 'selected' : ''; ?>>Unfurnished
                        </option>
                        <option value="Semi-Furnished"
                            <?php echo ($property['furnishing'] == 'Semi-Furnished') ? 'selected' : ''; ?>>
                            Semi-Furnished</option>
                        <option value="Fully-Furnished"
                            <?php echo ($property['furnishing'] == 'Fully-Furnished') ? 'selected' : ''; ?>>
                            Fully-Furnished</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="build_up_area">Build Up Area (sqft)</label>
                    <input type="number" name="build_up_area"
                        value="<?php echo htmlspecialchars($property['build_up_area']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="expected_rent">Expected Rent</label>
                    <input type="number" name="expected_rent"
                        value="<?php echo htmlspecialchars($property['expected_rent']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="expected_deposit">Expected Deposit</label>
                    <input type="number" name="expected_deposit"
                        value="<?php echo htmlspecialchars($property['expected_deposit']); ?>" required>
                </div>


                <div class="form-group">
                    <label for="area">Area</label>
                    <input type="text" name="area" id="area" value="<?php echo htmlspecialchars($property['area']); ?>"
                        class="location" placeholder="Area/Bangalore" required>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" value="<?php echo htmlspecialchars($property['city']); ?>"
                        class="location" placeholder="City/Bangalore" required>
                </div>

                <!-- <div class="form-group">
                <label for="state">State</label>
                <select name="state" id="state" class="location" required>
                    <option value="<?php echo htmlspecialchars($property['state']); ?>" disabled selected>Select State</option>
                </select>
            </div> -->

                <div class="form-group">
                    <label for="state">State</label>
                    <select name="state" id="state" class="location" required>
                        <option value="" disabled <?php echo empty($property['state']) ? 'selected' : ''; ?>>Select State</option>
                        <?php
                        // List of Indian states
                        $indianStates = [
                            "Andhra Pradesh",
                            "Arunachal Pradesh",
                            "Assam",
                            "Bihar",
                            "Chhattisgarh",
                            "Goa",
                            "Gujarat",
                            "Haryana",
                            "Himachal Pradesh",
                            "Jharkhand",
                            "Karnataka",
                            "Kerala",
                            "Madhya Pradesh",
                            "Maharashtra",
                            "Manipur",
                            "Meghalaya",
                            "Mizoram",
                            "Nagaland",
                            "Odisha",
                            "Punjab",
                            "Rajasthan",
                            "Sikkim",
                            "Tamil Nadu",
                            "Telangana",
                            "Tripura",
                            "Uttar Pradesh",
                            "Uttarakhand",
                            "West Bengal",
                            "Andaman and Nicobar Islands",
                            "Chandigarh",
                            "Dadra and Nagar Haveli and Daman and Diu",
                            "Lakshadweep",
                            "Delhi",
                            "Puducherry"
                        ];

                        // Populate the dropdown with options and select the saved state
                        foreach ($indianStates as $state) {
                            $isSelected = ($property['state'] === $state) ? 'selected' : '';
                            echo "<option value=\"$state\" $isSelected>$state</option>";
                        }
                        ?>
                    </select>
                </div>



                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" name="bathrooms"
                        value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="balcony">Balcony</label>
                    <input type="number" name="balcony" value="<?php echo htmlspecialchars($property['balcony']); ?>"
                        required>
                </div>
                <!-- <div class="form-group">
                    <label for="water_supply">Water Supply</label>
                    <input type="text" name="water_supply" value="<?php echo htmlspecialchars($property['water_supply']); ?>" required>
                </div> -->
                <div class="form-group">
                    <label for="water-supply">Water Supply</label>
                    <select name="water_supply" id="water-supply" required>
                        <option value="">Select Water Supply</option>
                        <option value="Municipal"
                            <?php echo ($property['water_supply'] == 'Municipal') ? 'selected' : ''; ?>>Municipal
                        </option>
                        <option value="Borewell"
                            <?php echo ($property['water_supply'] == 'Borewell') ? 'selected' : ''; ?>>Borewell</option>
                        <option value="Both(Municipal+borwell)"
                            <?php echo ($property['water_supply'] == 'Both(Municipal+borwell)') ? 'selected' : ''; ?>>
                            Both (Municipal + Borewell)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="property_age">Property Age</label>
                    <input type="text" name="property_age"
                        value="<?php echo htmlspecialchars($property['property_age']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="floor">Floor</label>
                    <input type="number" name="floor" value="<?php echo htmlspecialchars($property['floor']); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="total_floor">Total Floors</label>
                    <input type="number" name="total_floor"
                        value="<?php echo htmlspecialchars($property['total_floor']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="amenities">Amenities</label>

                    <div class="chechboxs">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Gym" id="amenity_gym"
                                name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Gym') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label checkbox-label" for="amenity_gym">Gym</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Servant Room"
                                id="amenity_servant_room" name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Servant Room') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_servant_room">Servant Room</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Play Area" id="amenity_play_area"
                                name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Play Area') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_play_area">Play Area</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Fire Safety" id="amenity_fire_safety"
                                name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Fire Safety') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_fire_safety">Fire Safety</label>
                        </div>
                    </div>

                    <!-- Second Column of Checkboxes -->
                    <div class="chechboxs">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Lift" id="amenity_lift"
                                name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Lift') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_lift">Lift</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Visitor Parking"
                                id="amenity_visitor_parking" name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Visitor Parking') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_visitor_parking">Visitor Parking</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Power Backup"
                                id="amenity_power_backup" name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Power Backup') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_power_backup">Power Backup</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="House Keeping"
                                id="amenity_house_keeping" name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'House Keeping') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_house_keeping">House Keeping</label>
                        </div>
                    </div>

                    <!-- Third Column of Checkboxes -->
                    <div class="chechboxs">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Air Conditioner"
                                id="amenity_air_conditioner" name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Air Conditioner') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_air_conditioner">Air Conditioner</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Club House" id="amenity_club_house"
                                name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Club House') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_club_house">Club House</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Internet Service"
                                id="amenity_internet_service" name="amenities[]"
                                <?php echo (strpos($property['amenities'], 'Internet Service') !== false) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="amenity_internet_service">Internet Service</label>
                        </div>
                    </div>


                </div>
                <!--  -->

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description"
                        required><?php echo htmlspecialchars($property['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="file_upload">Upload Images</label>
                    <input type="file" name="file_upload[]" multiple class="form-control">
                    <small>You can upload multiple images (optional)</small>
                </div>
                <button type="submit" class="btn btn-primary update-btn">Update Property</button>
            </form>
        </div>

    </div>





    <?php include('../footer.php'); ?>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"></script>
    <script>
        // List of Indian states
        const indianStates = [
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana",
            "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana",
            "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands", "Chandigarh",
            "Dadra and Nagar Haveli and Daman and Diu", "Lakshadweep", "Delhi", "Puducherry"
        ];

        // Populate the state dropdown
        function populateStateDropdown() {
            const stateDropdown = document.getElementById('state');
            indianStates.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateDropdown.appendChild(option);
            });
        }

        // Initialize Google Maps Places API for Area and City fields
        function initializeAutocomplete() {
            const areaInput = document.getElementById('area');
            const cityInput = document.getElementById('city');

            // Google Places autocomplete for Area
            const areaAutocomplete = new google.maps.places.Autocomplete(areaInput, {
                types: ['geocode'],
                componentRestrictions: {
                    country: 'in'
                }
            });

            // Google Places autocomplete for City
            const cityAutocomplete = new google.maps.places.Autocomplete(cityInput, {
                types: ['(cities)'], // Restrict to cities
                componentRestrictions: {
                    country: 'in'
                }
            });

            // Listener to autofill City and State based on selected area
            areaAutocomplete.addListener('place_changed', () => {
                const place = areaAutocomplete.getPlace();
                if (place && place.address_components) {
                    let city = '';
                    let state = '';

                    place.address_components.forEach(component => {
                        const types = component.types;
                        if (types.includes('locality')) {
                            city = component.long_name; // City
                        } else if (types.includes('administrative_area_level_1')) {
                            state = component.long_name; // State
                        }
                    });

                    if (city) cityInput.value = city;
                    if (state) selectState(state);
                }
            });

            // Function to select state in dropdown
            function selectState(state) {
                const stateDropdown = document.getElementById('state');
                for (let i = 0; i < stateDropdown.options.length; i++) {
                    if (stateDropdown.options[i].value === state) {
                        stateDropdown.selectedIndex = i;
                        break;
                    }
                }
            }
        }

        // Initialize dropdown and autocomplete on page load
        document.addEventListener('DOMContentLoaded', () => {
            populateStateDropdown();
            initializeAutocomplete();
        });
    </script>

    <script src="../js/script.js"></script>
</body>

</html>