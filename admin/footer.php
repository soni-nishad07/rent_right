<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
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
    <?php include('admin-link.php'); ?>
    <style>
            .footer-container
    {
        display:none;
    }
    </style>
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
                    <i class="fa fa-gear"></i>
                </div>
                <div class="header-title">
                    <h1>Footer</h1>
                    <small></small>
                    <div class="searchbar">
                        <form class="search-bar" role="search" method="POST">
                            <input class="form-control me-2" type="search" name="search_query" placeholder="Search"
                                aria-label="Search">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='footer'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <?php
                 
                 $search_query = '';
// Check if search_query is set
if (isset($_POST['search_query']) && !empty(trim($_POST['search_query']))) {
    $search_query = mysqli_real_escape_string($conn, trim($_POST['search_query']));
}

// Modify the SQL query to include a WHERE clause if a search query is provided
$query = "SELECT * FROM bhk_searches";
if ($search_query !== '') {
    // Normalize search query
    $normalized_search_query = strtolower(str_replace(' ', '', $search_query));
    $regex_pattern = ".*" . preg_replace("/[^a-zA-Z0-9]/", "", $normalized_search_query) . ".*";

    // Adjust SQL query to use REGEXP for matching
    $query .= " WHERE LOWER(REPLACE(name, ' ', '')) REGEXP '$regex_pattern'";
}
                    $res = mysqli_query($conn, $query);
                    if (mysqli_num_rows($res) > 0) {
                    ?>

                    <div class="col-sm-12 col-md-12">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group left-start">
                                    <a href="#">
                                        <h4>Popular BHK Searches </h4>
                                    </a>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="btn-group">
                                    <div class="buttonexport" id="buttonlist">
                                        <a class="btn btn-add" href="#" data-toggle="modal" data-target="#addcustom">
                                            <i class="fa fa-plus"></i> Add BHK Searches
                                        </a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Serial No</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $serial = 1;
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                // Escape special characters for JavaScript output
                                                $escaped_name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                            ?>
                                            <tr>
                                                <td><?php echo $serial; ?></td>
                                                <td><?php echo $row["name"]; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-add btn-sm" data-toggle="modal"
                                                        data-target="#customer1"
                                                        onclick="showUpdateModal(<?php echo $row['id']; ?>, '<?php echo $escaped_name; ?>')">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="showDeleteModal(<?php echo $row['id']; ?>)">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                            $serial++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    } else {
                        echo '<div class="alert alert-warning">No records found</div>';
                    }
                    ?>
                </div>
            </section>
        </div>

        <!-- Add BHK -->
        <div class="modal fade" id="addcustom" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-user m-r-5"></i> Add BHK</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="addBhkForm" class="form-horizontal" method="POST" action="footer_add_bhk.php">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Name:</label>
                                        <input type="text" name="name" placeholder="BHK Name" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-add btn-sm">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Update BHK -->
        <div class="modal fade" id="customer1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-user m-r-5"></i> Update BHK</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="updateBhkForm" class="form-horizontal" method="POST"
                                    action="footer_update_bhk.php">
                                    <input type="hidden" name="id" id="updateBhkId">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Name:</label>
                                        <input type="text" name="name" id="updateBhkName" placeholder="BHK Name"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-12 form-group user-form-group">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-add btn-sm">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Delete BHK Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3><i class="fa fa-trash-o m-r-5"></i> Delete BHK</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="deleteForm" method="POST" action="footer_delete_bhk.php">
                                    <fieldset>
                                        <input type="hidden" name="id" id="deleteId">
                                        <div class="form-group">
                                            <label class="control-label">Are you sure you want to delete this
                                                BHK?</label>
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-dismiss="modal">No</button>
                                                <button type="submit" class="btn btn-add btn-sm">Yes</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <script>
        function showUpdateModal(id, name) {
            // Set the ID and name in the update modal fields
            document.getElementById('updateBhkId').value = id;
            document.getElementById('updateBhkName').value = name;
            // Show the update modal
            // $('#customer1').modal('show');
        }

        function showDeleteModal(id) {
            // Set the ID in the hidden input field
            document.getElementById('deleteId').value = id;
            // Show the modal
            $('#deleteModal').modal('show');
        }
        </script>

        <!-- footer copyright -->
        <?php include('copy.php'); ?>

    </div>

    <?php include('footer-link.php'); ?>
</body>

</html>