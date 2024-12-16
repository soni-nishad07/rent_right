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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"
        async defer></script>

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



    <div class="container ">
        <form class="survey-form" method="post" action="post_insert.php" enctype="multipart/form-data">

            <div class="row row-cols-2 row-cols-lg-3 steps">
                <div class="col-4 col-lg-2 step current">
                    <a href="#" data-set-step="1">Property Details</a>
                </div>
                <div class="col-4 col-lg-2 step">
                    <a href="#" data-set-step="2">Locality Details</a>
                </div>
                <div class="col-4 col-lg-2 step">
                    <a href="#" data-set-step="3">Rental Details</a>
                </div>
                <div class="col-4 col-lg-2 step">
                    <a href="#" data-set-step="4">Amenities</a>
                </div>
                <div class="col-4 col-lg-2 step">
                    <a href="#" data-set-step="5">Gallery</a>
                </div>
                <div class="col-4 col-lg-2 step">
                    <a href="#" data-set-step="6">Schedule</a>
                </div>
            </div>




            <div class="step-content current" data-step="1">
                <div class="post-property-details">
                    <div class="property-type">
                        <!----------------- 1BHK---------------- -->

                        <!-- <div class="box-post">
                                    <select id="bhk-type" name="bhk_type">
                                        <option value="" required>BHK Type</option>
                                        <option value="1BHK" class="bhk">1 BHK</option>
                                        <option value="2BHK" class="bhk">2 BHK</option>
                                        <option value="3BHK" class="bhk">3 BHK</option>
                                        <option value="4BHK" class="bhk">4 BHK</option>
                                        <option value="5BHK" class="bhk">5 BHK</option>
                                        <option value="IndependentHouse">Independent House</option>

                                        <option value="IndependentHouse">1RK</option>
                                        <option value="IndependentHouse"> Commercial space</option>
                                        <option value="IndependentHouse">Land</option>
                                        <option value="IndependentHouse">Complete Building</option>
                                        <option value="IndependentHouse">Bungalow</option>
                                        <option value="IndependentHouse">Villa</option>
                                    </select>
                                </div> -->


                                         
                        <div class="box-post">
                                        <select id="owner-agent-select" name="owner_agent_type" onchange="toggleSecondDropdown()">
                                            <option value="">Select Owner or Agent</option>
                                            <option value="Owner">Owner</option>
                                            <option value="Agent">Agent</option>
                                        </select>
                                    </div>

                                    <div class="box-post" id="owner-options" style="display: none;">
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

                                    <div class="box-post" id="agent-options" style="display: none;">
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





                        <!--  -->
                        <div class="box-post">
                            <select name="property_type" id="property-type">
                                <option value="">-----Property Type-----</option>
                                <option value="Flat">Flat</option>
                                <option value="Building">Building</option>
                                <option value="Site">Site</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Villa">Villa</option>
                            </select>
                        </div>

                        <!--  -->
                        <div class="box-post">
                            <input type="text" name="build_up_area" placeholder="Builde Up Area  sqft"
                                id="build_up_area" class="area-sqft">
                        </div>
                    </div>

                    <div class="property-type2">
                        <div class="box-post">
                            <input type="text" name="property_age" placeholder="Property Age Type" id="property_age"
                                class="fields-post">

                        </div>

                        <!--  -->
                        <div class="box-post">
                            <input type="text" name="floor" placeholder="Floor" id="floor" class="fields-post">
                        </div>

                        <!--  -->
                        <div class="box-post">
                            <input type="text" name="total_floor" placeholder="Total Floor" id="total_floor"
                                class="fields-post">

                        </div>

                    </div>

                    <div class="buttons">
                        <!-- <a href="#" class="btn" data-set-step="2">Save & Continue</a> -->
                        <button type="button" class="btn" data-set-step="2">Save & Continue</button>
                    </div>
                </div>
            </div>



            <!-- page 2 -->
            <div class="step-content" data-step="2">
                <div class="post-property-details">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <input type="text" name="city" id="city" class="location" placeholder="City/Bangalore" />
                            <div class="buttons">
                                <!-- <a href="#" class="btn alt" data-set-step="1">Back</a>
                                <a href="#" class="btn" data-set-step="3">Save & Continue</a> -->
                                <button type="button" class="btn alt" data-set-step="1">Back</button>
                                <button type="button" class="btn" data-set-step="3">Save & Continue</button>
                            </div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                </div>
            </div>



            <!-- page 3 -->
            <div class="step-content" data-step="3">
                <div class="post-property-details">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <div class="Rental-Detail">
                                <div class="form-group">
                                    <label>Property Available For</label>
                                    <label class="checkbox-label"><input type="checkbox" name="available_for[]"
                                            value="Rent"> Rent</label>
                                    <label class="checkbox-label"><input type="checkbox" name="available_for[]"
                                            value="Sale"> Sale</label>
                                    <label class="checkbox-label"><input type="checkbox" name="available_for[]"
                                            value="Only Lease"> Only Lease</label>
                                </div>
                                <div class="form-group inline-group">
                                    <div class="inline-item">
                                        <input type="number" name="expected_rent" placeholder="Expected Rent">
                                        <span>/month</span>
                                    </div>
                                    <div class="inline-item">
                                        <input type="number" name="expected_deposit" placeholder="Expected Deposit">
                                    </div>
                                </div>
                                <div class="form-group inline-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="maintenance" value="Maintenance Included">
                                        Maintenance Included</label>
                                    <label class="checkbox-label"><input type="checkbox" name="maintenance"
                                            value="Maintenance Extra"> Maintenance Extra</label>
                                </div>
                                <div class="form-group">
                                    <input type="date" name="available_from" id="available_from"
                                        placeholder="Available from">
                                </div>
                                <div class="form-group">
                                    <label>Preferred Tenants</label>
                                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                                            value="Anyone"> Anyone</label>
                                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                                            value="Family"> Family</label>
                                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                                            value="Bachelor Female"> Bachelor Female</label>
                                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                                            value="Bachelor Male"> Bachelor Male</label>
                                    <label class="checkbox-label"><input type="checkbox" name="preferred_tenants[]"
                                            value="Company"> Company</label>
                                </div>
                                <div class="form-group inline-group">
                                    <div class="inline-item">
                                        <select name="furnishing">
                                            <option value="">--Select Furnishing---</option>
                                            <option value="Unfurnished">Unfurnished</option>
                                            <option value="Semi-Furnished"> Semi-Furnished
                                            </option>
                                            <option value="Fully-Furnished"> Fully-Furnished
                                            </option>
                                        </select>
                                    </div>
                                    <div class="inline-item">
                                        <!-- <input type="text" name="parking" id="parking" placeholder="Parking Area"> -->
                                        <select name="parking" id="parking">
                                            <option value="">--Select Parking---</option>
                                            <option value="Two-Wheeler">Two-Wheeler</option>
                                            <option value="Four-Wheeler">Four-Wheeler
                                            </option>
                                            <option value="Show-only-lease-properties"> Show only lease
                                                <br>
                                                properties
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group textarea-group">
                                    <textarea name="description"
                                        placeholder="Write a description about your property if needed."></textarea>
                                </div>
                            </div>
                            <div class="buttons">
                                <a href="#" class="btn alt" data-set-step="2">Back</a>
                                <a href="#" class="btn" data-set-step="4">Save & Continue</a>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>

            </div>


            <!-- page 4 -->
            <div class="step-content" data-step="4">
                <div class="post-property-details">

                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">

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
                                <div class="water">
                                    <select name="water_supply" id="water-supply">
                                        <option value="">Water Supply</option>
                                        <option value="Municipal">Municipal</option>
                                        <option value="Borewell">Borewell</option>
                                        <option value="Both(Municipal+borwell)">Both(Municipal+borwell)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="amentities_row2">
                                <div class="heading">
                                    <h2>Select the available amentities</h2>
                                </div>

                                <div class="amentities">

                                    <div class="chechboxs">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Gym"
                                                id="amentities_choose" name="amenities[]" checked>
                                            <label class="form-check-label  checkbox-label">
                                                Gym
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Servent Room"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Servent Room </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Kids Play Area "
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Kids Play Area </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="  Fire Safety "
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Fire Safety </label>
                                        </div>


                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Garden area"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Garden area</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Yoga centre"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Yoga centre</label>
                                        </div>

                                    </div>

                                    <div class="chechboxs">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Lift"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Lift
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="  Visitor Parking "
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Visitor Parking </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=" Power Backup "
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Power Backup </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="  House Keeping "
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                House Keeping </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Party Hall"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Party Hall</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Security"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Security</label>
                                        </div>


                                    </div>


                                    <div class="chechboxs">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="   Air Conditioner"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Air Conditioner
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=" Club House"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Club House </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="  Internet Service"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Internet Service</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="CCTV"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                CCTV</label>
                                        </div>


                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Swimming Pool"
                                                id="amentities_choose" name="amenities[]">
                                            <label class="form-check-label">
                                                Swimming Pool</label>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="buttons">
                                <a href="#" class="btn alt" data-set-step="3">Back</a>
                                <a href="#" class="btn" data-set-step="5">Save & Continue</a>
                            </div>

                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                </div>

            </div>


            <!-- page 5 -->
            <div class="step-content" data-step="5">
                <div class="post-property-details">

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">

                            <div class="upload-container">
                                <p>Add photos or Videos of your property</p>
                                <label class="upload-button">
                                    Upload
                                    <input type="file" name="file_upload[]" id="file_upload"
                                        accept="image/png, image/jpg, image/jpeg" class="form-control" multiple>
                                </label>
                                <p id="file_count">No files selected</p>
                            </div>
                            <div class="buttons">
                                <a href="#" class="btn alt" data-set-step="4">Back</a>
                                <a href="#" class="btn" data-set-step="6">Save & Continue</a>
                            </div>

                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                </div>

            </div>


            <!-- page 6 -->
            <div class="step-content" data-step="6">
                <div class="post-property-details">

                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">

                            <div class="availability-container">
                                <div class="availability">
                                    <b>
                                        <p>Availability</p>
                                    </b>
                                    <br />
                                    <button type="button" class="availability-btn"
                                        data-value="Everyday (Mon-Sun)">Everyday (Mon-Sun)</button>
                                    <button type="button" class="availability-btn"
                                        data-value="Weekday (Mon-Fri)">Weekday (Mon-Fri)</button>
                                    <button type="button" class="availability-btn"
                                        data-value="Weekend (Sat-Sun)">Weekend (Sat-Sun)</button>
                                    <input type="hidden" name="availability" id="availability" />
                                </div>

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

                                <div class="checkbox-container">
                                    <label>
                                        <input type="checkbox" name="available_all" id="available_all"> Available All
                                        Day
                                    </label>
                                </div>
                            </div>
                            <div class="buttons">
                                <a href="#" class="btn alt" data-set-step="5">Back</a>
                                <input type="submit" class="btn submit-btn" name="submit" value="Submit">
                            </div>

                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                </div>

            </div>


            <!-- page 7 -->
            <div class="step-content" data-step="7">
                <div class="result">
                    <?= $response ?>
                </div>
            </div>



        </form>
    </div>


 



    <script>

        // bathrooms increment and derement
        document.addEventListener('DOMContentLoaded', function () {
            const minus = document.querySelector('.quantity__minus');
            const plus = document.querySelector('.quantity__plus');
            const input = document.querySelector('.quantity__input');

            minus.addEventListener('click', function (e) {
                e.preventDefault();
                let value = parseInt(input.value);
                if (value > 1) {
                    value--;
                    input.value = value;
                }
            });

            plus.addEventListener('click', function (e) {
                e.preventDefault();
                let value = parseInt(input.value);
                value++;
                input.value = value;
            });
        });


        // balcony increment and decrement
        document.addEventListener('DOMContentLoaded', function () {
            const minus = document.querySelector('.quantity__minus2');
            const plus = document.querySelector('.quantity__plus2');
            const input = document.querySelector('.quantity__input2');

            minus.addEventListener('click', function (e) {
                e.preventDefault();
                let value = parseInt(input.value);
                if (value > 1) {
                    value--;
                    input.value = value;
                }
            });

            plus.addEventListener('click', function (e) {
                e.preventDefault();
                let value = parseInt(input.value);
                value++;
                input.value = value;
            });
        });



        // --------------------------------------------------steps-------------


        document.addEventListener('DOMContentLoaded', function () {
            // Step Navigation Logic
            const setStep = step => {
                document.querySelectorAll(".step-content").forEach(element => element.style.display = "none");
                document.querySelector("[data-step='" + step + "']").style.display = "block";
                document.querySelectorAll(".steps .step").forEach((element, index) => {
                    index < step - 1 ? element.classList.add("complete") : element.classList.remove("complete");
                    index == step - 1 ? element.classList.add("current") : element.classList.remove("current");
                });
            };

            document.querySelectorAll("[data-set-step]").forEach(element => {
                element.onclick = event => {
                    event.preventDefault();
                    setStep(parseInt(element.dataset.setStep));
                };
            });


            // File count update
            document.getElementById('file_upload').addEventListener('change', function () {
                var fileInput = document.getElementById('file_upload');
                var fileCount = fileInput.files.length;
                var fileCountText = fileCount > 0 ? fileCount + ' file(s) selected' : 'No files selected';
                document.getElementById('file_count').textContent = fileCountText;
            });

            // Availability button selection
            document.querySelectorAll('.availability-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    document.getElementById('availability').value = this.getAttribute('data-value');
                    document.querySelectorAll('.availability-btn').forEach(function (btn) {
                        btn.classList.remove('selected');
                    });
                    this.classList.add('selected');
                });
            });



            // Initialize Google Maps 
            function initializeAutocomplete() {
                var input = document.getElementById('city');
                var autocomplete = new google.maps.places.Autocomplete(input);
            }
            google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
        });
    </script>

<?php
    include('../footer.php');
    ?>



<script>
                            // Function to toggle the visibility of second dropdown based on selection
                            function toggleSecondDropdown() {
                                const selectElement = document.getElementById("owner-agent-select");
                                const ownerOptions = document.getElementById("owner-options");
                                const agentOptions = document.getElementById("agent-options");

                                // Hide both options by default
                                ownerOptions.style.display = "none";
                                agentOptions.style.display = "none";

                                // Show the corresponding dropdown based on selection
                                if (selectElement.value === "Owner") {
                                    ownerOptions.style.display = "block";  // Show Owner options
                                } else if (selectElement.value === "Agent") {
                                    agentOptions.style.display = "block";  // Show Agent options
                                }
                            }
                        </script>

    <script src="../js/script.js"></script>

</body>

</html>