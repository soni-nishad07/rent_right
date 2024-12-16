<?php
include('../connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login');
    exit();
}
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
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"
        async defer></script> -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"></script>
    <script>
        // Initialize Google Maps 
        function initializeAutocomplete() {
            var input = document.getElementById('city');
            var autocomplete = new google.maps.places.Autocomplete(input);
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

                <!-- BHK Options for Owner and Agent -->
                <div class="form-control" id="owner-options" style="display: none;">
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
                </div>


                <!-- Property Type Selection -->
                <div class="form-control">
                    <label for="propertyType">Property Type:</label>
                    <select id="propertyType" name="property_type" required>
                        <option value="">--Select Property Type--</option>
                        <option value="Flat">Flat</option>
                        <option value="Building">Building</option>
                        <option value="Site">Site</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Villa">Villa</option>
                    </select>
                </div>
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
            <div class="form-section" data-step="2">
                <h2>Locality Details</h2>
                <!-- City -->
                <div class="form-control">
                    <label for="city">Location:</label>
                    <input type="text" id="city" name="city" class="location" placeholder="City/Bangalore" required>
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
                        <label for="deposit">Deposit:</label>
                        <input type="number" name="expected_deposit" placeholder="Expected Deposit" required>
                    </div> -->
                        <div class="inline-item">
                        <label for="expected_deposit">Deposit:</label>
                        <!-- <input type="number" name="expected_deposit" placeholder="Expected Deposit" required> -->
                        <select name="expected_deposit" required>
                    <option value="">Select Expected Deposit</option>
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
                    </div>
                </div>

                <div class="form-group inline-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="maintenance" value="Maintenance Included"> Maintenance Included
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="maintenance" value="Maintenance Extra"> Maintenance Extra
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
                                <input class="form-check-input" type="checkbox" value="Gym" name="amenities[]" >
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

    <script>
    function initAutocomplete() {
        const input = document.getElementById("city");
        const options = {
            types: ['(cities)'], // Only show city suggestions
            componentRestrictions: { country: 'IN' } // Restrict to India
        };
        new google.maps.places.Autocomplete(input, options);
    }

    // Initialize the autocomplete after the API script loads
    document.addEventListener("DOMContentLoaded", function() {
        initAutocomplete();
    });
</script>



    <script src="../js/post.js"></script>
    <script src="../js/script.js"></script>

</body>

</html>