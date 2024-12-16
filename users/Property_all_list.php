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
    <title>Property Lists - Rent Right Bangalore</title>
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


    .zoom {
            transition: transform .2s; /* Animation */
        }

        .zoom:hover {
            transform: scale(1.1); /* Zoom effect */
        }


    </style>
</head>

<body>

<?php  include('user-head.php');  ?>

    <div class="container">
        <div class="property-card-heading">
            <h4>All Property Lists</h4>
        </div>

        <?php 
            // Display messages
            if ($message) {
                echo "<div class='alert alert-" . ($messageType === 'error' ? 'danger' : 'success') . "'>$message</div>";
            }

            // $query = "
            //     SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
            //     FROM properties 
            //     JOIN customer_register ON properties.user_id = customer_register.id";

                $query = "
    SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
    FROM properties 
    JOIN customer_register ON properties.user_id = customer_register.id 
    WHERE properties.approval_status = 'Approved'";



            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $images = explode(',', $row['file_upload']);
        ?>
        <div class="property-card_list row">
            <div class="col-md-6 image-container_list">
                <?php if (count($images) > 0) { ?>
                <div id="propertySlider<?php echo htmlspecialchars($row['id']); ?>" class="carousel slide"
                    data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                            foreach ($images as $index => $image) {
                                $active = $index == 0 ? 'active' : '';
                                echo "<div class='carousel-item $active'>
                                        <img src='" . htmlspecialchars($image) . "' class='d-block w-100 zoom' alt='Property Image'>
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
            <div class="col-md-6 details-container_list">
                <div class="price">₹ <?php echo htmlspecialchars($row['expected_rent']); ?></div>
                <div class="status">For <?php echo htmlspecialchars($row['available_for']); ?></div>
                <div class="location"><?php echo htmlspecialchars($row['city']) ?>
                </div>
                <div class="features_list">
                    <div class="feature">
                        <span>&#127968;</span> <!-- House Icon -->
                        <span><?php echo htmlspecialchars($row['property_type']); ?></span>
                    </div>
                    <div class="feature">
                        <span>&#128142;</span> <!-- Tag Icon -->
                        <span><?php echo htmlspecialchars($row['available_for']); ?></span>
                    </div>
                    <div class="feature">
                        <span><i class="fas fa-trowel"></i></span> <!-- Wrench Icon -->
                        <span><?php echo htmlspecialchars($row['available_from']); ?></span>
                    </div>
                    <div class="feature">
                        <span>&#128719;</span> <!-- Bed Icon -->
                        <span><?php echo htmlspecialchars($row['bhk_type']); ?></span>
                    </div>
                    <div class="feature">
                        <span><i class="fas fa-couch"></i></span> <!-- Sofa Icon -->
                        <span><?php echo htmlspecialchars($row['furnishing']); ?></span>
                    </div>
                    <div class="feature">
                        <span><i class="fas fa-maximize"></i></span> <!-- Ruler Icon -->
                        <span><?php echo htmlspecialchars($row['build_up_area']); ?> sqft</span>
                    </div>
                </div>
                <div class="buttons_list">
                    <a href="property_all_list_details.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                        class="btn btn-info">View Property</a>
                    <a href="#" class="enquiry btn btn-primary" data-bs-toggle="modal" data-bs-target="#enquiryModal"
                        data-property-id="<?php echo htmlspecialchars($row['id']); ?>">Send Enquiry</a>
                </div>
                <div class="footer_list">
                    <div class="user">
                        <!-- <?php echo htmlspecialchars($row['name']); ?> <br> -->
                    <!--    <?php echo htmlspecialchars($row['emailaddress']); ?> <br>  -->
                  <!--        <?php echo htmlspecialchars($row['phonenumber']); ?>  -->
                    </div>
                    <div class="date"><?php echo date('d M y', strtotime($row['created_at'])); ?></div>
                </div>
            </div>
        </div>
        <?php
                }
            } else {
                echo "<p>No Property List.</p>";
            }
        ?>
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

    <?php
     include('../footer.php');
    ?>
    
    <script src="../js/script.js"></script>
    <script>
    // Set the property ID in the modal when the enquiry button is clicked
    const enquiryButtons = document.querySelectorAll('.enquiry');
    enquiryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.getAttribute('data-property-id');
            document.getElementById('modal_property_id').value = propertyId;
        });
    });
    </script>
</body>

</html>