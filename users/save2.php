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
                                    <div class="contact-property">
                                        <div class="contact-button">
                                            <button class="btn btn-primary form-control contact-owner"
                                                data-property-id="<?php echo $row['id']; ?>">Contact
                                                Owner</button>
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









    <div class="modal" id="contact-owner-modal" style="display:none;">
        <div class="modal-header">
            <h2>Contact Owner</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body owner_popup">
            <p>To contact the owner, please select one of the following options:</p>
            <div class="buttons owner_popup_btn">
                <textarea id="message-text" placeholder="Type your message here..." rows="3"
                    class="form-control"></textarea>
                <button class="btn message-owner" onclick="sendMessage()">Send Message</button>
                <input type="datetime-local" id="visit-date" class="form-control" />
                <button class="btn schedule-visit" onclick="scheduleVisit()">Schedule a Visit</button>
            </div>
            <div class="nb-tip">
                <span class="nb-tip-icon"><i class="fa-solid fa-lightbulb"></i></span>
                <p>Note: Ensure to verify the details of the property before making any payments.</p>
            </div>
        </div>
    </div>



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







