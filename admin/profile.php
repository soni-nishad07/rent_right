<?php
include "../connection.php";

session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index');
    exit;
}

// Fetch user details
$user_id = $_SESSION['id'];
$query = "SELECT username, email FROM admin_register WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Update profile details if form is submitted
if (isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    $update_query = "UPDATE admin_register SET username = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    $update_stmt->execute();

    // Refresh user details
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo "<script>alert('Profile updated successfully.');</script>";
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
        <?php
        include('header.php');
        include('sidebar.php');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon"><i class="fa fa-user-circle-o"></i></div>
                <div class="header-title">
                    <h1>Profile</h1>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="panel panel-bd">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4>Setting</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="panel-shadow1">
                                    <div class="profile panel-title">
                                        <h4>Profile Update</h4>
                                    </div>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <input type="text" id="username" class="form-control" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" value="<?php echo htmlspecialchars($row['email']); ?>" id="email" class="form-control" name="email" placeholder="Enter Email" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-add" name="update"><i class="fa fa-check"></i> Update</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="panel-shadow1">
                                    <div class="profile panel-title">
                                        <h4>Change Password</h4>
                                    </div>
                                    <button type="button" class="btn btn-add" data-toggle="modal" data-target="#changePasswordModal"><i class="fa fa-check"></i> Change Password</button>
                                    <p>We will send you an email to reset or change your password.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Change Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="change_password.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


         
         <!-- footer copyright -->
        <?php
include('copy.php');
    ?>

    </div>
    <!-- /.wrapper -->

    <?php include('footer-link.php'); ?>
</body>
</html>
