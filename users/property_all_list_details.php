<?php
include('../connection.php');
include('session_check.php');

// Initialize message variables
$message = '';
$messageType = ''; // 'success' or 'error'

// Handle enquiry submission
if (isset($_POST['send_enquiry'])) {
    $property_id = $_POST['property_id'];
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
    $enquiry_message = $_POST['enquiry_message'];

    // Validate message length
    if (strlen($enquiry_message) < 10) {
        $message = 'Message must be at least 10 characters long.';
        $messageType = 'error';
    } else {
        // Check if enquiry already exists
        $check_enquiry_query = "SELECT * FROM enquiries WHERE user_id = '$user_id' AND property_id = '$property_id'";
        $check_result = mysqli_query($conn, $check_enquiry_query);

        if (mysqli_num_rows($check_result) > 0) {
            $message = 'You have already sent an enquiry for this property.';
            $messageType = 'error';
        } else {
            // Prepare and execute the SQL statement
            $insert_enquiry_query = "INSERT INTO enquiries (user_id, property_id, message) VALUES ('$user_id', '$property_id', '$enquiry_message')";
            
            if (mysqli_query($conn, $insert_enquiry_query)) {
                $message = 'Enquiry sent successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to send enquiry. Please try again.';
                $messageType = 'error';
            }
        }
    }
}
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property View Lists- Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>
    <style>
        .modal {
            position: fixed !important;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: var(--bs-modal-zindex) !important;
            display: none;
        }

        /* --------------------------------------zooming--------------img-------------- */


.carousel-item img {
    width: 100%;
    height: auto;
    cursor: pointer;
}

/* Modal images should also be responsive */
.modal-body img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease-in-out;
}

/* Zoom-In Effect */
.modal-body img:hover {
    transform: scale(1.1);
}

/* Add some padding inside the modal */
.modal-body {
    padding: 20px;
}

/* Ensure the modal is full-screen on smaller devices */
@media (max-width: 768px) {
    .modal-dialog {
        width: 100%;
        max-width: none;
        margin: 0;
    }

    .modal-content {
        height: 100%;
    }
}

    </style>
</head>

<body>

<?php  include('user-head.php');  ?>

    <div class="container">
        <div class="property-card-heading">
            <h4>All View Property</h4>
        </div>


        <?php


 // Display messages
 if ($message) {
    echo "<div class='alert alert-" . ($messageType === 'error' ? 'danger' : 'success') . "'>$message</div>";
}

// Check if the property ID is set in the URL
if (isset($_GET['id'])) {
    $propertyId = intval($_GET['id']); // Ensure the ID is an integer

    // Fetch property details for the specific ID
    $query = "
        SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
        FROM properties 
        JOIN customer_register ON properties.user_id = customer_register.id 
        WHERE properties.id = $propertyId";
        
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "No Property Found.";
        exit; // Stop further execution if no property is found
    }

    $row = mysqli_fetch_assoc($result);
    $images = explode(',', $row['file_upload']);
} else {
    echo "Property ID is not specified.";
    exit; // Stop further execution if ID is not specified
}
?>


        <div class="row">
            <div class="propery_listing">
                <div class="listing_image">
                    <?php if (count($images) > 0) { ?>
                    <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">

                        <!-- Image Slider -->
                        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($images as $index => $image) { 
                                 $active = $index == 0 ? 'active' : ''; ?>
                                <div class="carousel-item <?php echo $active; ?>">
                                    <img src="<?php echo htmlspecialchars($image); ?>"
                                        class="d-block w-100 property-image" alt="Property Image"
                                        data-index="<?php echo $index; ?>">
                                </div>
                                <?php } ?>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>


                        <!-- <button class="carousel-control-prev" type="button"
                            data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->

                    </div>
                    <?php } ?>
                </div>
                <div class="property_basic-info">
                    <h2>For
                        <?php echo htmlspecialchars($row['available_for']); ?>
                    </h2>
                    <p><i class="fas fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($row['city'] ); ?>
                    </p>
                    <div class="property_price-info">
                        <span class="price">₹
                            <?php echo htmlspecialchars($row['expected_rent']); ?>
                        </span>
                        <span class="user">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </span>
                        <span class="contact"><i class="fas fa-phone-alt"></i>
                            <?php echo htmlspecialchars($row['emailaddress']); ?>
                        </span>
                        <span class="type"><i class="fas fa-home"></i>
                            <?php echo htmlspecialchars($row['property_type']); ?>
                        </span>
                        <span class="status"><i class="fas fa-tag"></i>
                            <?php echo htmlspecialchars($row['available_for']); ?>
                        </span>
                        <span class="date"><i class="fas fa-calendar-alt"></i>
                            <?php echo date('d M y', strtotime($row['created_at'])); ?>
                        </span>
                    </div>
                </div>
                <div class="property_list_details">
                    <h3>Details</h3>
                    <div class="details-grid_list">
                        <p><strong>Rooms:</strong>
                            <?php echo htmlspecialchars($row['bhk_type']); ?>
                        </p>
                        <p><strong>Deposit amount:</strong> ₹
                            <?php echo htmlspecialchars($row['expected_deposit']); ?>
                        </p>
                        <p><strong>Status:</strong>
                            <?php echo date('d M y', strtotime($row['available_from'])); ?>
                        </p>
                        <p><strong>Bathroom:</strong>
                            <?php echo htmlspecialchars($row['bathrooms']); ?>
                        </p>
                        <p><strong>Balcony:</strong>
                            <?php echo htmlspecialchars($row['balcony']); ?>
                        </p>
                        <p><strong>Water Supply:</strong>
                            <?php echo htmlspecialchars($row['water_supply']); ?>
                        </p>
                        <p><strong>Carpet area:</strong>
                            <?php echo htmlspecialchars($row['build_up_area']); ?> sqft
                        </p>
                        <p><strong>Age:</strong>
                            <?php echo htmlspecialchars($row['property_age']); ?>
                        </p>
                        <p><strong>Floor:</strong>
                            <?php echo htmlspecialchars($row['floor']); ?>
                        </p>
                        <p><strong>Total Floors:</strong>
                            <?php echo htmlspecialchars($row['total_floor']); ?>
                        </p>
                        <p><strong>Furnished:</strong>
                            <?php echo htmlspecialchars($row['furnishing']); ?>
                        </p>
                    </div>
                </div>
                <div class="amenities_list">
                    <h3>Amenities</h3>
                    <ul>
                        <li><i class="fas fa-check"></i>
                            <?php echo htmlspecialchars($row['amenities']); ?>
                        </li>
                    </ul>
                </div>
                <div class="description_list">
                    <h3>Description</h3>
                    <p>
                        <?php echo htmlspecialchars($row['description']); ?>
                    </p>
                </div>
                <div class="actions_list">
                    <button class="saved btn btn-success" data-property-id="<?php echo $row['id']; ?>"><i
                            class="fas fa-heart"></i> Save</button>
                    <!-- <button class="enquiry" >Send Enquiry</button> -->

                    <a href="#" class="enquiry btn btn-danger" data-bs-toggle="modal" data-bs-target="#enquiryModal"
                        data-property-id="<?php echo htmlspecialchars($row['id']); ?>">Send Enquiry</a>
                </div>

            </div>
        </div>
    </div>





    <!-- Enquiry Modal -->
    <div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enquiryModalLabel">Send Enquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="property_id" id="modal_property_id">
                        <div class="mb-3">
                            <label for="enquiryMessage" class="form-label">Your Message</label>
                            <textarea class="form-control" id="enquiryMessage" name="enquiry_message" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" name="send_enquiry" class="btn btn-primary">Send Enquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal for Zoom-In Effect -->
    <div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-labelledby="lightboxModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lightboxModalLabel">Image Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="lightboxCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="lightboxCarouselInner">
                            <!-- Zoomed Images will be dynamically inserted here -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <?php
     include('../footer.php');
    ?>


    <script src="../js/script.js"></script>


    <script>
        // Set the property ID in the modal when the enquiry button is clicked
        const enquiryButtons = document.querySelectorAll('.enquiry');
        enquiryButtons.forEach(button => {
            button.addEventListener('click', function () {
                const propertyId = this.getAttribute('data-property-id');
                document.getElementById('modal_property_id').value = propertyId;
            });
        });


        // image zoom in slider
        document.querySelectorAll('.property-image').forEach((image, index) => {
            image.addEventListener('click', function () {

                const images = document.querySelectorAll('.carousel-item img');

                const clickedIndex = this.getAttribute('data-index');

                const lightboxCarouselInner = document.getElementById('lightboxCarouselInner');
                lightboxCarouselInner.innerHTML = ''; // Clear previous items

                images.forEach((img, i) => {
                    const imgSrc = img.getAttribute('src');
                    const activeClass = i == clickedIndex ? 'active' : '';
                    lightboxCarouselInner.innerHTML += `
                <div class="carousel-item ${activeClass}">
                    <img src="${imgSrc}" class="d-block w-100 zoomed-image" alt="Zoomed Image">
                </div>`;
                });


                // Show the modal
                $('#imageLightboxModal').modal('show');
            });
        });


        $(document).ready(function () {
            $('.saved').click(function () {
                var propertyId = $(this).data('property-id');
                $.post('saved_properties.php', {
                    property_id: propertyId
                }, function (response) {
                    alert(response.message);
                }, 'json');
            });
        });
    </script>


</body>

</html>