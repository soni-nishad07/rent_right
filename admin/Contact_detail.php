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
                    <i class="fa fa-address-book"></i>
                </div>
                <div class="header-title">
                    <h1>Contact Us Details</h1>
                    <small></small>
                    <div class="searchbar">
                        <form class="search-bar" role="search" method="POST">
                            <input class="form-control me-2" type="search" name="search_query" placeholder="Search"
                                aria-label="Search">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='Contact_detail'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">

                 
                        <?php
                        // Initialize search query variable
                        $search_query = '';
                        // Check if search_query is set
                        if (isset($_POST['search_query']) && !empty(trim($_POST['search_query']))) {
                            $search_query = mysqli_real_escape_string($conn, trim($_POST['search_query']));
                        }

                        // SQL query to fetch data, including search functionality
                        $query = "SELECT * FROM contact_messages";
                        if ($search_query !== '') {
                            $query .= " WHERE name LIKE '%$search_query%' 
                                        OR email LIKE '%$search_query%' 
                                        OR mobile LIKE '%$search_query%' 
                                        OR message LIKE '%$search_query%'";
                        }

                        $query .= " ORDER BY created_at DESC";  // Assuming `created_at` is the field for registration date.


                        $res = mysqli_query($conn, $query);

                        if (mysqli_num_rows($res) > 0) {
                        ?>

                        <div class="col-sm-12 col-md-12">
                            <div class="panel panel-bd panel-shadow">
                                <div class="panel-heading">
                                    <div class="btn-group">
                                        <a href="#">
                                        <h4>Contact Messages</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="dataTableExample1"
                                            class="table table-bordered table-striped table-hover">
                                            <thead>
                                            <tr class="info">
                                                <th>Customer Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Received On</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                ?>
                                                   
                                                   <tr>
                                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                                                    <td><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?>
                                                    </td>
                                        
                                                <td>
                                                    <!-- Delete button -->
                                                    <button class="btn btn-danger btn-xs" onclick="deleteMessage(<?php echo $row['id']; ?>)">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </td>

                                                </tr>

            
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                    </div>


                                    <script>
                                

                                        // Delete message function
                                        function deleteMessage(id) {
                                            if (confirm('Are you sure you want to delete this message?')) {
                                                window.location.href = 'contact_delete_message.php?id=' + id; // Redirect to delete_message.php with ID
                                            }
                                        }
                                    </script>
                                
                                
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



        <!-- footer copyright -->
        <?php
        include('copy.php');
        ?>

    </div>


    <?php include('footer-link.php'); ?>
</body>

</html>