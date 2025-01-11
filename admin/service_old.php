<?php
session_start();
include('../connection.php'); // Ensure this file sets up $conn

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index');
    exit;
}

$search_query = '';
if (isset($_POST['search_query']) && !empty(trim($_POST['search_query']))) {
    $search_query = mysqli_real_escape_string($conn, trim($_POST['search_query']));
}

$query = "SELECT * FROM services";
if ($search_query !== '') {
    $query .= " WHERE service_name LIKE '%$search_query%'";
}

$res = mysqli_query($conn, $query);
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
    <!-- Preloader -->
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
                    <i class="fa fa-cart-plus"></i>
                </div>
                <div class="header-title">
                    <h1>Services</h1>
                    <div class="searchbar">
                        <form class="search-bar" role="search" method="POST">
                            <input class="form-control me-2" type="search" name="search_query" placeholder="Search" aria-label="Search">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='service'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <?php if (mysqli_num_rows($res) > 0) { ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group left-start">
                                    <h4>Service List</h4>
                                </div>
                                <!-- Optionally add a button to add a service -->
                            </div>

                            <div class="panel-body">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-add" data-toggle="modal" data-target="#adduser">
                                        <i class="fa fa-plus"></i> Add Service
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>Service Image</th>
                                                <th>Service Name</th>
                                                <th>Service Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                            <tr>
                                                <td>
                                                    <img src="../uploads/services/<?php echo htmlspecialchars($row['service_img']); ?>" alt="Service Image" width="60" >
                                                </td>
                                                <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['service_description']); ?></td>
                                                <td>

                                                    <!-- <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#update"
                                                        onclick="setUpdateModal('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['service_name']); ?>', 
                                                        '<?php echo htmlspecialchars($row['service_img']); ?>')">
                                                        <i class="fa fa-pencil"></i>
                                                    </button> -->

                                                    <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#update"
                                                        onclick="setUpdateModal('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['service_name']); ?>', 
                                                        '<?php echo htmlspecialchars($row['service_description']); ?>', '<?php echo htmlspecialchars($row['service_img']); ?>')">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>


                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#customer2"
                                                        onclick="setDeleteModal('<?php echo $row['id']; ?>')">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>

                                                    
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="alert alert-warning">No records found</div>
                    <?php } ?>
                </div>
            </section>
            
        </div>


<!-- Update Service Modal -->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><i class="fa fa-pencil m-r-5"></i> Update Service</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="update_service.php" enctype="multipart/form-data">
                    <input type="hidden" name="service_id" id="update_service_id">
                    <fieldset>
                        <div class="col-md-12 form-group">
                            <label class="control-label">Photo</label>
                            <input name="service_img" class="input-file" type="file">
                            <img id="update_service_img" src="" alt="Service Image" style="max-width: 60px; margin-top: 10px;">
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="control-label">Service Name</label>
                            <input type="text" name="service_name" id="update_service_name" placeholder="Service Name" class="form-control" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="control-label">Service Description</label>
                            <input type="text" name="service_description" id="update_service_description" placeholder="Service Description" class="form-control" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <div class="pull-right">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-add btn-sm">Update</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


        <!-- Add Service Modal -->
        <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-plus m-r-5"></i> Add New Service</h3>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="insert_service.php" enctype="multipart/form-data">
                            <fieldset>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Photo</label>
                                    <input name="service_img" class="input-file" type="file" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Service Name</label>
                                    <input type="text" name="service_name" placeholder="Service Name" class="form-control" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Service description</label>
                                    <input type="text" name="service_description" placeholder="Service description" class="form-control" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-add btn-sm">Add</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Service Modal -->
        <div class="modal fade" id="customer2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-trash-o m-r-5"></i> Delete Service</h3>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="delete_service.php">
                            <input type="hidden" name="service_id" id="delete_service_id">
                            <fieldset>
                                <div class="col-md-12 form-group">
                                    <label class="control-label">Are you sure you want to delete this service?</label>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-add btn-sm">Yes</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function setUpdateModal(serviceId, serviceName, serviceDescription, serviceImg) {
            document.getElementById('update_service_img').src = serviceImg ? "../uploads/services/" + serviceImg : ''; // Ensure a valid image path
            document.getElementById('update_service_id').value = serviceId;
            document.getElementById('update_service_name').value = serviceName;
            document.getElementById('update_service_description').value = serviceDescription;
        }
        </script>


        <?php include('copy.php'); ?>
    </div>

    <?php include('footer-link.php'); ?>
</body>

</html>
