<?php
include('../connection.php');
include('session_check.php');

// Handle removal of saved property
if (isset($_GET['remove_id']) && isset($_SESSION['user_id'])) {
    $remove_id = mysqli_real_escape_string($conn, $_GET['remove_id']); // Sanitize input
    $user_id = $_SESSION['user_id'];

    $remove_query = "DELETE FROM saved_properties WHERE property_id = '$remove_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $remove_query)) {
        // Store a success message in session to display after redirect
        $_SESSION['message'] = 'Property removed from saved listings successfully.';
        header("Location: saved.php?success=1"); // Redirect with success message
        exit(); // Always exit after a redirect
    } else {
        echo "Error removing saved property: " . mysqli_error($conn);
    }
}

//---------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------------


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
    <title>Saved Properties - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    </style>
</head>

<body>

    <?php include('user-head.php');  ?>


    <div class="container mt-4">
        <div class="property-card-heading mb-3">
            <h4>Saved Listings</h4>
        </div>

        <?php
        // Display messages
        if ($message) {
            echo "<div class='alert alert-" . ($messageType === 'error' ? 'danger' : 'success') . "'>$message</div>";
        }

        ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Property removed from saved listings successfully.
            </div>
        <?php endif; ?>

        <?php
        $user_id = $_SESSION['user_id'];
        $query = "
        SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
        FROM saved_properties 
        JOIN properties ON saved_properties.property_id = properties.id 
        JOIN customer_register ON properties.user_id = customer_register.id
        WHERE saved_properties.user_id = '$user_id'";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $images = explode(',', $row['file_upload']);
        ?>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card property-card_saved">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php if (count($images) > 0) { ?>
                                            <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide"
                                                data-bs-ride="carousel">
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
                                                    data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="property-price_saved">₹
                                                <?php echo number_format($row['expected_rent']); ?></h5>
                                            <a href="saved.php?remove_id=<?php echo $row['id']; ?>"
                                                class="btn btn-secondary text-white">Remove from Saved</a>
                                        </div>
                                        <p class="property-type_saved"><?php echo htmlspecialchars($row['available_for']); ?>
                                        </p>
                                        <p class="property-location_saved"><i class="fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($row['city']); ?></p>
                                        <div class="property-details_saved">
                                            <span><i class="fas fa-home"></i>
                                                <?php echo htmlspecialchars($row['property_type']); ?></span>
                                            <span><i class="fas fa-bed"></i>
                                                <?php echo htmlspecialchars($row['bhk_type']); ?></span>
                                            <span><i class="fas fa-check"></i>
                                                <?php echo htmlspecialchars($row['furnishing']); ?></span>
                                            <span><i class="fas fa-calendar-alt"></i>
                                                <?php echo date('d M Y', strtotime($row['created_at'])); ?></span>
                                        </div>
                                        <p class="property-description_saved">
                                            <?php echo htmlspecialchars($row['description']); ?></p>
                                        <div class="property-actions_saved mt-3">
                                            <a href="property_all_list_details.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-danger text-white">View Property</a>


                                            <a href="#" class="enquiry btn btn-danger text-white" data-bs-toggle="modal"
                                                data-bs-target="#enquiryModal"
                                                data-property-id="<?php echo htmlspecialchars($row['id']); ?>">Send Enquiry</a>
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
            echo "<p>No Saved Properties.</p>";
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

    <script>
        $(document).ready(function() {
            // Hide the success message after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut(500, function() {
                    $(this).remove(); // Remove message from DOM after fading out
                });
            }, 5000); // Show for 5 seconds
        });
    </script>


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