<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index');
    exit;
}

include('../connection.php'); // Make sure to include your database connection

// Check if the status update form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $property_id = $_POST['property_id'];
    $new_status = $_POST['status'];

    // Sanitize inputs
    $property_id = mysqli_real_escape_string($conn, $property_id);
    $new_status = mysqli_real_escape_string($conn, $new_status);

    // Update the property status in the database
    $update_query = "UPDATE properties SET property_status='$new_status' WHERE id='$property_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Status updated successfully');</script>";
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
}



if (isset($_POST['update_approval'])) {
    $property_id = $_POST['property_id'];
    $approval_status = isset($_POST['approval_status']) ? $_POST['approval_status'] : 'Pending';

    // Update the database with the new approval status
    $query = "UPDATE properties SET approval_status = '$approval_status' WHERE id = '$property_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Approval status updated successfully.";
    } else {
        echo "Error updating approval status.";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>

    <?php include('admin-link.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <!--preloader-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-sticky-note-o"></i>
                </div>
                <div class="header-title">
                    <h1>Property Posted</h1>
                    <small><br /></small>

                    <div class="searchbar">
                        <form class="search-bar" method="POST" action="">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search"
                                aria-label="Search">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='Property_post'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        // Get filter values
                        $search = isset($_POST['search']) ? $_POST['search'] : '';
                        $filter_month = isset($_POST['filter_month']) ? $_POST['filter_month'] : '';
                        $filter_owner = isset($_POST['filter_owner']) ? $_POST['filter_owner'] : '';
                        $filter_apartment_type = isset($_POST['filter_apartment_type']) ? $_POST['filter_apartment_type'] : '';
                        $filter_property_type = isset($_POST['filter_property_type']) ? $_POST['filter_property_type'] : '';

                        // Modify the query to include the filters
                        $query = "
                        SELECT properties.*, customer_register.name, customer_register.emailaddress, customer_register.phonenumber 
                        FROM properties 
                        JOIN customer_register ON properties.user_id = customer_register.id
                        WHERE 1=1
                        ";

                        if ($search) {
                            $search = mysqli_real_escape_string($conn, strtolower($search));
                            $query .= " AND (
                                LOWER(properties.id) LIKE '%$search%' OR
                                LOWER(customer_register.name) LIKE '%$search%' OR
                                LOWER(REPLACE(properties.bhk_type, ' ', '')) LIKE '%" . str_replace(' ', '', $search) . "%' OR
                                LOWER(properties.property_type) LIKE '%$search%' OR
                                LOWER(customer_register.emailaddress) LIKE '%$search%' OR
                                LOWER(properties.created_at) LIKE '%$search%'
                            )";
                        }

                        if ($filter_month) {
                            $query .= " AND DATE_FORMAT(properties.created_at, '%Y-%m') = '$filter_month'";
                        }
                        if ($filter_owner) {
                            $query .= " AND LOWER(customer_register.name) LIKE '%" . strtolower($filter_owner) . "%'";
                        }
                        if ($filter_apartment_type) {
                            $query .= " AND LOWER(REPLACE(properties.bhk_type, ' ', '')) LIKE '%" . str_replace(' ', '', strtolower($filter_apartment_type)) . "%'";
                        }
                        if ($filter_property_type) {
                            $query .= " AND LOWER(properties.property_type) LIKE '%" . strtolower($filter_property_type) . "%'";
                        }

                        $res = mysqli_query($conn, $query);
                        if (mysqli_num_rows($res) > 0) {
                        ?>

                        <div class="row">
                            <div class="panel">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-11">
                                    <form method="POST" action="" class="filter-form">
                                        <div class="btn-group filter">
                                            <h4>Filter</h4>
                                        </div>
                                        <input type="month" name="filter_month" class="btn btn-add gray-border"
                                            value="<?php echo $filter_month; ?>">
                                        <input type="text" name="filter_owner" placeholder="Owner"
                                            class="btn btn-add gray-border"
                                            value="<?php echo htmlspecialchars($filter_owner); ?>">
                                        <input type="text" name="filter_apartment_type" placeholder="Apartment Type"
                                            class="btn btn-add gray-border"
                                            value="<?php echo htmlspecialchars($filter_apartment_type); ?>">
                                        <input type="text" name="filter_property_type" placeholder="Property Type"
                                            class="btn btn-add gray-border"
                                            value="<?php echo htmlspecialchars($filter_property_type); ?>">
                                        <button type="submit" class="btn btn-add red"><i class="fa fa-check"></i>
                                            Apply</button>
                                        <button type="reset" class="btn btn-add red-border"
                                            onclick="window.location.href='Property_post'">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-bd panel-shadow mt-20">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>Property ID</th>
                                                <th>Property Owner Name</th>
                                                <th> Owner or Agent</th>
                                                <th>Apartment Type</th>
                                                <th>Property Type</th>
                                                <th>Phone Number</th>
                                                <th>City</th>
                                                <th>Rent</th>
                                                <th>Deposit</th>
                                                <th>Date</th>
                                                <th>Top Project Status</th>
                                                <th>Update Status</th>
                                                <th>Project approval Status</th>
                                                <th>Update approval</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                // Dynamically assign status label classes
                                                $status_class = '';
                                                switch($row['property_status']) {
                                                    case 'Spotlight':
                                                        $status_class = 'label-success_spotlight';
                                                        break;
                                                    case 'Focus':
                                                        $status_class = 'label-info';
                                                        break;
                                                    case 'Trending':
                                                        $status_class = 'label-warning';
                                                        break;
                                                    case 'Featured':
                                                        $status_class = 'label-primary';
                                                        break;
                                                    case 'Sale and Commercial':
                                                            $status_class = 'label-Secondary';
                                                            break;
                                                    case 'Cancel':
                                                        $status_class = 'label-danger';
                                                        break;
                                                    default:
                                                        $status_class = 'label-default';
                                                        break;
                                                }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $row['id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['owner_agent_type']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['bhk_type']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['property_type']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['phonenumber']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['city']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['expected_rent']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['expected_deposit']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['created_at']; ?>
                                                </td>
                                                <td>
                                                    <span class="label <?php echo $status_class; ?>" style="border:0px">
                                                        <?php echo $row['property_status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <form method="POST" action="">
                                                        <input type="hidden" name="property_id"
                                                            value="<?php echo $row['id']; ?>">
                                                        <select name="status" class="form-control" required
                                                            style="height:35px;border:0px; margin: 10px 0px;">
                                                            <option value="" disabled selected>Select Status</option>
                                                            <option value="Spotlight">Spotlight</option>
                                                            <option value="Focus">Focus</option>
                                                            <option value="Trending">Trending</option>
                                                            <option value="Featured">Featured</option>
                                                            <option value="Sale and Commercial">Sale & Commercial</option>
                                                            <option value="Cancel">Cancel</option>
                                                        </select>
                                                        <button type="submit" name="update_status"
                                                            class="btn btn-add  ">Update</button>
                                                    </form>
                                                </td>



                                                <td>
                                                    <span
                                                        class="label <?php echo strtolower($row['approval_status']) === 'pending' ? 'label-warning' : ($row['approval_status'] === 'Approved' ? 'label-success' : 'label-danger'); ?>"
                                                        style="border:0px">
                                                        <?php echo $row['approval_status'] ? $row['approval_status'] : 'Pending'; ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <form method="POST" action="">
                                                        <input type="hidden" name="property_id"
                                                            value="<?php echo $row['id']; ?>">
                                                        <select name="approval_status" class="form-control" required
                                                            style="height:35px;border:0px; margin: 10px 0px;">
                                                            <option value="" disabled>Select Approval Status</option>
                                                            <option value="Approved" <?php echo
                                                                ($row['approval_status']=='Approved' ) ? 'selected' : ''
                                                                ; ?>>Approve</option>
                                                            <option value="Rejected" <?php echo
                                                                ($row['approval_status']=='Rejected' ) ? 'selected' : ''
                                                                ; ?>>Reject</option>
                                                        </select>
                                                        <button type="submit" name="update_approval"
                                                            class="btn update_approv_sts  mt-2">Update Approval</button>
                                                    </form>
                                                </td>



                                                <!-- seee more -->
                                                <td style="color:#009688;"><a
                                                        href="property_details.php?id=<?php echo $row['id']; ?>">See
                                                        more</a></td>
                                                <!-- end see more  -->

                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    } else {
                                        echo '<div class="alert alert-warning">No records found</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <?php include('copy.php'); ?>
    </div>

    <?php include('footer-link.php'); ?>
</body>

</html>