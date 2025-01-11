<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>

    <?php
    include('admin-link.php');
    ?>

</head>

<body class="hold-transition sidebar-mini">
    <!--preloader-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php
        include('header.php');
        include('sidebar.php');
        ?>

        <div class="content-wrapper">
            <section class="content-header">

                <div class="header-icon">
                    <i class="fa fa-sticky-note-o"></i>
                </div>

                <div class="header-title">
                    <h1>Property Details</h1>
                    <small><br /></small>


                    <div class="searchbar">
                        <form class="search-bar" method="GET" action="">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='property_details'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <?php

                        // Get the property ID from the URL
                        $property_id = isset($_GET['id']) ? $_GET['id'] : '';

                        // Fetch the property details
                        $query = "
                        SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
                        FROM properties 
                        JOIN customer_register ON properties.user_id = customer_register.id
                        WHERE properties.id = '$property_id'";

                        

                        $res = mysqli_query($conn, $query);
                        if (mysqli_num_rows($res) > 0) {
                            $row = mysqli_fetch_assoc($res);
                        ?>


                        <div class="row">
                            <div class="panel">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">

                                    <a href="Property_post" class="back-btn">
                                        <button type="submit" class="btn btn-add red-border"> Back
                                        </button>
                                    </a>


                                </div>

                            </div>
                        </div>

                        <div class="panel panel-bd panel-shadow mt-20">
                            <div class="panel-body2">
                                <div class="table-responsive2">
                                    <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Property ID</th>
                                                <td>
                                                    <?php echo $row['id']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Owner Name</th>
                                                <td>
                                                    <?php echo $row['name']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Owner Number</th>
                                                <td>
                                                    <?php echo $row['phonenumber']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Owner Gmail</th>
                                                <td>
                                                    <?php echo $row['emailaddress']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Apartment Type</th>
                                                <td>
                                                    <?php echo $row['bhk_type']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Type</th>
                                                <td>
                                                    <?php echo $row['property_type']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Area Sqft</th>
                                                <td>
                                                    <?php echo $row['build_up_area']; ?>sqft
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Age Type</th>
                                                <td>
                                                    <?php echo $row['property_age']; ?> year
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Floor</th>
                                                <td>
                                                    <?php echo $row['floor']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Floor</th>
                                                <td>
                                                    <?php echo $row['total_floor']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    <?php echo $row['area']; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>City</th>
                                                <td>
                                                    <?php echo $row['city']; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>State</th>
                                                <td>
                                                    <?php echo $row['state']; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Property Available For</th>
                                                <td>
                                                    <?php echo $row['available_for']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Expected Rent</th>
                                                <td>
                                                    <?php echo $row['expected_rent']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Expected Deposit</th>
                                                <td>
                                                    <?php echo $row['expected_deposit']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Maintenance</th>
                                                <td>
                                                    <?php echo $row['maintenance']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Available From</th>
                                                <td>
                                                    <?php echo $row['available_from']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Preferred Tenants</th>
                                                <td>
                                                    <?php echo $row['preferred_tenants']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Furnishing</th>
                                                <td>
                                                    <?php echo $row['furnishing']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Parking Area</th>
                                                <td>
                                                    <?php echo $row['parking']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Description</th>
                                                <td>
                                                    <?php echo $row['description']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Bathroom</th>
                                                <td>
                                                    <?php echo $row['bathrooms']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Balcony</th>
                                                <td>
                                                    <?php echo $row['balcony']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Water Supply</th>
                                                <td>
                                                    <?php echo $row['water_supply']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Available Amenities</th>
                                                <td>
                                                    <?php echo $row['amenities']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Images</th>
                                                <td>
                                                    <?php
                                                    $images = explode(',', $row['file_upload']);
                                                    foreach ($images as $image) {
                                                        echo '<img src="' . $image . '" alt="Image not found" height="150px" width="160px" style="margin: 5px;">';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Availability</th>
                                                <td>
                                                    <?php echo $row['availability']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Start Time</th>
                                                <td>
                                                    <?php echo $row['start_time']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>End Time</th>
                                                <td>
                                                    <?php echo $row['end_time']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Available All Day</th>
                                                <td>
                                                    <?php echo $row['available_all']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Property Posted Date</th>
                                                <td>
                                                    <?php echo $row['created_at']; ?>
                                                </td>
                                            </tr>

                                            <tr>


                                                <!-- Row for buttons -->
                                            <tr>
                                                <td colspan="2" style="text-align: center;">
                                             
                                      <!-- Delete Button -->
                                    <button onclick="confirmDelete(<?php echo $row['id']; ?>)" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer;">Delete</button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <hr style="background-color:white; border:0;color:white;" />
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                else {
                                                    echo "<tr><td colspan='2'>Record not found</td></tr>";
                                                }
                                                ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>



        <!-- footer copyright -->
        <?php
include('copy.php');
    ?>

    </div>

    <?php
    include('footer-link.php');
    ?>


<script>
function confirmDelete(propertyId) {
    if (confirm("Are you sure you want to delete this property? This action cannot be undone.")) {
        window.location.href = "delete_property.php?id=" + propertyId; // Redirect to delete script
    }
}
</script>


</body>

</html>