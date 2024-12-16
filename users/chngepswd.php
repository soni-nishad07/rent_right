<?php
include('../connection.php');
include('session_check.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>
</head>

<body>
<?php include('user-head.php'); ?>

    <div class="container">
        <div class="change" id="editProfile">
            <h1 class="form-title">Change Password</h1>
            <form method="post" action="password_edit.php" class="form-group">
                <div class="input-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" id="currentPassword" name="current_password" class="form-control" 
                        placeholder="Current Password" required>
                </div>

                <div class="input-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="new_password" class="form-control" 
                        placeholder="New Password" required>
                </div>

                <div class="input-group">
                    <label for="cnfPassword">Confirm Password</label>
                    <input type="password" id="cnfPassword" name="cnf_password" class="form-control" 
                        placeholder="Confirm Password" required>
                </div>

                <input type="submit" class="btn editbtn" name="ChangePassword" value="Change Password">
            </form>
        </div>
    </div>

    <?php include('../footer.php'); ?>

    <script src="../js/script.js"></script>
</body>

</html>
