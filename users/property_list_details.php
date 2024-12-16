<?php
include('../connection.php');
include('session_check.php');

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    $query = "SELECT properties.*, customer_register.name, customer_register.emailaddress FROM properties 
              JOIN customer_register ON properties.user_id = customer_register.id
              WHERE properties.id = '$property_id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
        $images = explode(',', $property['file_upload']);
    } else {
        die('Property not found.');
    }
} else {
    die('Invalid property ID.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property View - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>

    <style>
        /* Carousel images */
        .carousel-item img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50000;
        }

        /* Modal images */
        .modal-body img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease-in-out;
        }

        .modal-body {
            padding: 20px;
        }

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
            <h4>User View Property</h4>
        </div>

        <div class="row">
            <div class="propery_listing">
                <div class="listing_image">
                    <?php if (count($images) > 0) { ?>
                    <div id="propertySlider<?php echo htmlspecialchars($property['id']); ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php 
                            foreach ($images as $index => $image) {
                                $active = $index == 0 ? 'active' : '';
                                // echo "<div class='carousel-item $active'>
                                //         <img src='" . htmlspecialchars($image) . "' class='d-block w-100' alt='Property Image'>
                                //       </div>";

                                            echo "<div class='carousel-item $active'>
                                             <img src='" . htmlspecialchars($image) . "' class='d-block w-100' alt='Property Image' data-bs-toggle='modal' data-bs-target='#imageLightboxModal' data-image='" . htmlspecialchars($image) . "' data-index='$index'>
                                      </div> ";
                            }
                            ?>
                        </div>


                        <!-- <button class="carousel-control-prev" type="button"
                            data-bs-target="#propertySlider<?php echo htmlspecialchars($property['id']); ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#propertySlider<?php echo htmlspecialchars($property['id']); ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->


                        <button class="carousel-control-prev" type="button" data-bs-target="#propertySlider<?php echo htmlspecialchars($property['id']); ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#propertySlider<?php echo htmlspecialchars($property['id']); ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>


                    </div>
                    <?php } ?>
                </div>


                <div class="property_basic-info">
                    <h2>For <?php echo htmlspecialchars($property['available_for']); ?></h2>
                    <p><i class="fas fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($property['area']); ?>
                    </p>
                    <div class="property_price-info">
                        <span class="price">₹ <?php echo htmlspecialchars($property['expected_rent']); ?></span>
                        <span class="user"><?php echo htmlspecialchars($property['name']); ?></span>
                        <span class="contact"><i class="fas fa-phone-alt"></i>
                            <?php echo htmlspecialchars($property['emailaddress']); ?></span>
                        <span class="type"><i class="fas fa-home"></i>
                            <?php echo htmlspecialchars($property['property_type']); ?></span>
                        <span class="status"><i class="fas fa-tag"></i>
                            <?php echo htmlspecialchars($property['available_for']); ?></span>
                        <span class="date"><i class="fas fa-calendar-alt"></i>
                            <?php echo date('d M y', strtotime($property['created_at'])); ?></span>
                    </div>
                </div>
                <div class="property_list_details">
                    <h3>Details</h3>
                    <div class="details-grid_list">
                        <p><strong>Rooms:</strong> <?php echo htmlspecialchars($property['bhk_type']); ?></p>
                        <p><strong>Deposit amount:</strong> ₹ <?php echo htmlspecialchars($property['expected_deposit']); ?></p>
                        <p><strong>Status:</strong> <?php echo date('d M y', strtotime($property['available_from'])); ?></p>
                        <p><strong>Bathroom:</strong> <?php echo htmlspecialchars($property['bathrooms']); ?></p>
                        <p><strong>Balcony:</strong> <?php echo htmlspecialchars($property['balcony']); ?></p>
                        <p><strong>Water Supply:</strong> <?php echo htmlspecialchars($property['water_supply']); ?></p>
                        <p><strong>Carpet area:</strong> <?php echo htmlspecialchars($property['build_up_area']); ?> sqft</p>
                        <p><strong>Age:</strong> <?php echo htmlspecialchars($property['property_age']); ?></p>
                        <p><strong>Floor:</strong> <?php echo htmlspecialchars($property['floor']); ?></p>
                        <p><strong>Total Floors:</strong> <?php echo htmlspecialchars($property['total_floor']); ?></p>
                        <p><strong>Furnished:</strong> <?php echo htmlspecialchars($property['furnishing']); ?></p>
                    </div>
                </div>
                <div class="amenities_list">
                    <h3>Amenities</h3>
                    <ul>
                        <li><i class="fas fa-check"></i> <?php echo htmlspecialchars($property['amenities']); ?></li>
                    </ul>
                </div>
                <div class="description_list">
                    <h3>Description</h3>
                    <p><?php echo htmlspecialchars($property['description']); ?></p>
                </div>
                <div class="description_list">
                    <h3>Approval Status</h3>
                    <!-- <p><?php echo htmlspecialchars($property['approval_status']); ?></p> -->
                    <p  class="approved"  style="color: <?php echo htmlspecialchars($property['approval_status']) === 'Approved' ? '#1eb24e' : (htmlspecialchars($property['approval_status']) === 'Rejected' ? 'red' : 'black'); ?>">
    <?php echo htmlspecialchars($property['approval_status']); ?>
</p>

                </div>
                <div class="actions_list">
                    <button class="saved btn btn-success" data-property-id="<?php echo htmlspecialchars($property['id']); ?>"><i class="fas fa-heart"></i> Save</button>
                    <a href="delete.php?id=<?php echo htmlspecialchars($property['id']); ?>" onclick="return checkdelete();">Delete</a>
                </div>
            </div>
        </div>
    </div>

    
    

        <!-- Modal for Zoom-In Effect -->
        <div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-labelledby="lightboxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lightboxModalLabel">Image Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="zoomedImage" src="" alt="Zoomed Image">
                </div>
                <div class="modal-footer">
                    <button id="prevImage" class="btn btn-secondary">Previous</button>
                    <button id="nextImage" class="btn btn-secondary">Next</button>
                </div>
            </div>
        </div>
    </div>

    
    
    
    <!-- Delete confirmation -->
    <script>
    function checkdelete() {
        return confirm('Are you sure you want to delete this property?');
    }
    </script>
    <!-- Confirmation delete end -->




    <script>
    $(document).ready(function() {
        $('.saved').click(function() {
            var propertyId = $(this).data('property-id');
            $.post('saved_properties.php', {
                property_id: propertyId
            }, function(response) {
                alert(response.message);
            }, 'json');
        });
    });



           // Zoom image in modal and setup navigation
           let images = <?php echo json_encode($images); ?>; // Pass images array to JS
        let currentIndex;

        $('.carousel-item img').click(function() {
            currentIndex = $(this).data('index');
            $('#zoomedImage').attr('src', $(this).data('image'));
            $('#imageLightboxModal').modal('show');
        });

        $('#prevImage').click(function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1; // Navigate to previous image
            $('#zoomedImage').attr('src', images[currentIndex]);
        });

        $('#nextImage').click(function() {
            currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0; // Navigate to next image
            $('#zoomedImage').attr('src', images[currentIndex]);
        });
        

    </script>

    <script src="../js/script.js"></script>

    <?php include('../footer.php'); ?>

</body>

</html>
