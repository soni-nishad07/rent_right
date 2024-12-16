<?php
session_start();
include('../connection.php');

$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Rent Right Bangalore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="shortcut icon" href="../admin/assets/images/favi.ico" type="image/x-icon">
    <script src="../js/bootstrap.bundle.js"></script>
    <?php include('../links.php'); ?>
</head>

<body>


<?php  include('user-head.php');  ?>


    <?php
    $id = $_SESSION['user_id'];
    $query = "SELECT * FROM customer_register WHERE id='$id'";
    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
    ?>
    <div class="container">
        <div class="profile" id="editProfile">
            <h1 class="form-title">Edit Profile</h1>
            <form method="post" action="profile_edit.php" class="form-group">
                <div class="input-group">
                    <label for="name">Enter Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>"
                        placeholder="Enter Your Full Name" required>
                </div>
                <div class="input-group">
                    <label for="emailaddress">Email Address</label>
                    <input type="email" id="emailaddress" name="emailaddress" class="form-control"
                        value="<?php echo $row['emailaddress']; ?>" placeholder="Enter email address" required>
                </div>
                <div class="input-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="number" id="phonenumber" name="phonenumber" class="form-control"
                        value="<?php echo $row['phonenumber']; ?>" placeholder="Enter Phone Number" required>
                </div>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="submit" class="btn editbtn" name="EditProfile" value="Update Profile">
            </form>
        </div>
    </div>
    <?php
    } else {
        echo "<p>User not found.</p>";
    }
    ?>

    <?php include('../footer.php'); ?>

    <script src="../js/script.js"></script>
</body>

</html>


