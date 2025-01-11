<?php
include('../connection.php');
include('session_check.php');


$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    // die('User not logged in.');
    echo "<script>
  alert('login first');
                window.location.href = '../login';
    }
    </script>";
}

// Fetch saved properties for the user
$savedPropertiesQuery = "SELECT properties.* FROM properties
                         JOIN save_items ON properties.id = save_items.property_id
                         WHERE save_items.user_id = ?";
$stmt = mysqli_prepare($conn, $savedPropertiesQuery);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$savedPropertiesResult = mysqli_stmt_get_result($stmt);
$savedProperties = mysqli_fetch_all($savedPropertiesResult, MYSQLI_ASSOC);

// Handle removal of saved property
if (isset($_GET['remove_id'])) {
    $removeId = intval($_GET['remove_id']);
    $removeQuery = "DELETE FROM save_items WHERE user_id = ? AND property_id = ?";
    $stmt = mysqli_prepare($conn, $removeQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $removeId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['success_message'] = "Property successfully removed.";
        echo "<script>
        alert('Property successfully removed.');
        window.location.href = 'save';
      </script>";   
        header("Location: save.php");
        
        exit();
    } else {
        $_SESSION['error_message'] = "Error: Unable to remove the property.";
        header("Location: save.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Properties</title>
    <link rel="stylesheet" href="../css/property.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>
</head>

<body>
    <?php include('user-head.php'); ?>
    <div class="overlay" id="overlay"></div>

    <main>
        <div class="container">
            <div class="save-heading">
                <h4 class="text-center">Saved Property List</h4>
            </div>
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-danger text-center'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);
            }

            if (isset($_SESSION['success_message'])) {
                echo "<div class='alert alert-success text-center'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']);
            }

            if (!empty($savedProperties)) {
                foreach ($savedProperties as $row) {
                    $images = explode(',', $row['file_upload']);
            ?>
            <div class="row properties">
                <div class="col-lg-12">
                    <div class="card property-box mb-3">
                        <div class="row g-0">
                            <div class="col-md-3 property-image">
                                <div class='image-placeholder'>
                                    <?php if (count($images) > 0) { ?>
                                    <div id="propertySlider<?php echo htmlspecialchars($row['id']); ?>"
                                        class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php 
                                            foreach ($images as $index => $image) {
                                                $active = $index == 0 ? 'active' : '';
                                                echo "<div class='carousel-item $active'>
                                                        <img src='" . htmlspecialchars($image) . "' class='d-block w-100' alt='Property Image'>
                                                      </div>";
                                            }
                                            ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#propertySlider<?php echo htmlspecialchars($row['id']); ?>"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#propertySlider<?php echo htmlspecialchars($row['id']); ?>"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-2 property-details">
                                <div class="detail-item">Rent- <?php echo htmlspecialchars($row['expected_rent']); ?>
                                </div>                                          
                                <div class="detail-item">Location-
                                    <?php echo htmlspecialchars($row['area']); ?></div>
                                <div class="detail-item_area">Area-
                                    <?php echo htmlspecialchars($row['build_up_area']); ?> sqft</div>
                            </div>

                            <div class="col-md-7">
                                <div class="property-body">
                                    <div class="property-info">
                                        <div class="info-item">
                                            <?php echo htmlspecialchars($row['furnishing']); ?><br><span>Furnishing</span>
                                        </div>
                                        <div class="info-item">
                                            <?php echo htmlspecialchars($row['bhk_type']); ?><br><span>Apartment
                                                Type</span></div>
                                        <div class="info-item">
                                            <?php echo htmlspecialchars($row['preferred_tenants']); ?><br><span>Tenant
                                                Type</span></div>
                                        <div class="info-item">
                                            <?php echo htmlspecialchars($row['available_from']); ?><br><span>Available</span>
                                        </div>
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
                                            <a href="save.php?remove_id=<?php echo htmlspecialchars($row['id']); ?>"
                                                class="btn btn-danger form-control save_remove ">Remove</a>
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
                echo "<div class='no-properties'>No saved properties found.</div>";
            }
            ?>
        </div>
    </main>


    
    <?php
        include('../footer.php');
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

                    <!-- <div class="input-group-custom">
                        <input type="date" id="booking_date_custom" name="booking_date" required>
                    </div> -->

                    <div class="input-group-custom">
                        <!-- <span>Provide Date For Booking!</span> -->
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
                // var date = document.getElementById("booking_date_custom").value;
                // if (name == "" || email == "" || mobile == "" || date == "") {
                    if (name == "" || email == "" || mobile == "" ) {
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
    const isLoggedIn = true; // Assuming the user is logged in based on PHP session
    document.querySelectorAll('.contact-owner').forEach(button => {
        button.addEventListener('click', () => {
            if (isLoggedIn) {
                showModal();
            } else {
                alert('Please log in to contact the owner.');
                window.location.href = '../login';
            }
        });
    });

    function showModal() {
        document.getElementById('contact-owner-modal').style.display = 'block';
        document.getElementById('overlay').style.display = 'block'; // Ensure you have an overlay element
    }

    function closeModal() {
        document.getElementById('contact-owner-modal').style.display = 'none';
        document.getElementById('overlay').style.display = 'none'; // Ensure you have an overlay element
    }

    function sendMessage() {
        const message = document.getElementById('message-text').value;
        const propertyId = document.querySelector('.contact-owner').getAttribute('data-property-id');

        if (!message) {
            alert('Please enter a message.');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_message.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Message sent successfully!');
                closeModal();
            } else {
                alert('Failed to send message.');
            }
        };
        xhr.send('property_id=' + propertyId + '&message=' + encodeURIComponent(message));
    }

    function scheduleVisit() {
        const visitDate = document.getElementById('visit-date').value;
        const propertyId = document.querySelector('.contact-owner').getAttribute('data-property-id');

        if (!visitDate) {
            alert('Please select a date and time.');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'schedule_visit.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Visit scheduled successfully!');
                closeModal();
            } else {
                alert('Failed to schedule visit.');
            }
        };
        xhr.send('property_id=' + propertyId + '&visit_date=' + encodeURIComponent(visitDate));
    }

    function sendMapLocation() {
        alert('Send Map Location functionality coming soon.');
    }
    </script>

</body>

</html>







