<?php
include('../connection.php');
include('session_check.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Property List - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>
    <style>
        .zoom {
            transition: transform 0.2s; 
            cursor: pointer; 
        }

        .zoom:hover {
            transform: scale(1.5); 
        }
    </style>
</head>

<body>


<?php  include('user-head.php');  ?>


    <div class="container">
        <div class="property-card-heading">
            <h4>User Property List</h4>
        </div>

        <?php 
            $user_id = $_SESSION['user_id'];
            $query = "
                SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
                FROM properties 
                JOIN customer_register ON properties.user_id = customer_register.id
                WHERE properties.user_id = '$user_id'";
            
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $images = explode(',', $row['file_upload']);
        ?>
        <div class="property-card_list row">
            <div class="col-md-6 image-container_list">
                <?php if (count($images) > 0) { ?>
                <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                            foreach ($images as $index => $image) {
                                $active = $index == 0 ? 'active' : '';
                                echo "<div class='carousel-item $active'>
                                        <img src='$image' class='d-block w-100 zoom'  alt='Property Image' data-bs-toggle='modal' data-bs-target='#imageModal{$row['id']}'>
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
            <div class="col-md-6 details-container_list">
                <div class="price">₹  <?php echo $row['expected_rent']; ?></div>
                <div class="status">For <?php echo $row['available_for']; ?></div>
                <div class="location"> <?php echo $row['city']; ?></div>
                <div class="features_list">
                    <div class="feature"><span>&#127968;</span> <span><?php echo $row['property_type']; ?></span></div>
                    <div class="feature"><span>&#128142;</span> <span><?php echo $row['available_for']; ?></span></div>
                    <div class="feature"><span><i class="fas fa-trowel"></i></span> <span><?php echo $row['available_from']; ?></span></div>
                    <div class="feature"><span>&#128719;</span> <span><?php echo $row['bhk_type']; ?></span></div>
                    <div class="feature"><span><i class="fas fa-couch"></i></span> <span><?php echo $row['furnishing']; ?></span></div>
                    <div class="feature"><span><i class="fas fa-maximize"></i></span> <span><?php echo $row['build_up_area']; ?> sqft</span></div>
                </div>


                <!-- <div class="buttons_list">
                    <a href="updatee.php?id=<?php echo $row['id']; ?>">Update</a>
                </div> -->

                <!-- <div class="buttons_list">
                    <a href="update_property_list.php?id=<?php echo $row['id']; ?>">Update</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return checkdelete();">Delete</a>
                </div> -->


                <!-- approved condition -->
                <div class="buttons_list">
                <?php if ($row['approval_status'] == 'Approved') { ?>
                    <a href="#" onclick="showApprovalAlert(); return false;">Update</a>
                <?php } else { ?>
                    <a href="update_property_list.php?id=<?php echo $row['id']; ?>">Update</a>
                <?php } ?>
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return checkdelete();">Delete</a>
            </div>


                <div class="buttons_list2">
                    <a href="property_list_details.php?id=<?php echo $row['id']; ?>">See View Property</a>
                    <!-- <a href="viewcode.php?id=<?php echo $row['id']; ?>">See View Property</a> -->

                </div>
                <div class="footer_list">
                    <div class="user">
                        <!-- <?php echo $row['name']; ?><br> -->
                       <!-- <?php echo $row['emailaddress']; ?><br>  -->
                        <!-- <?php echo $row['phonenumber']; ?>  -->
                    </div>
                    <div class="date"><?php echo $row['created_at']; ?></div>
                </div>
            </div>
        </div>
        <?php
                }
            } else {
                echo "No Property List.";
            }
        ?>
    </div>

    <?php include('../footer.php'); ?>



    <!-- approved msg  -->
    <script>
    function showApprovalAlert() {
        alert('This property is approved and cannot be updated.');
    }
    </script>


    <script>
    function checkdelete() {
        return confirm('Are you sure you want to delete this property?');
    }
    </script>
    <script src="../js/script.js"></script>
</body>

</html>
