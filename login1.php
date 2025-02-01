<?php
include('connection.php');
session_start();

if (isset($_POST['Signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['emailaddress']);
    $phone = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $current_date = date('Y-m-d H:i:s'); // Get the current date and time
    $user_unique_id = uniqid('user_', true); // Generate a unique user ID

    $checkEmailQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        echo "<script>
        alert('Email already registered. Please log in.');
        window.location.href = 'login';
        </script>";
        exit();
    } else {
        $registerQuery = "INSERT INTO customer_register (user_unique_id, name, emailaddress, phonenumber, password, `date`) VALUES ('$user_unique_id', '$name', '$email', '$phone', '$hashed_password', '$current_date')";
        if ($conn->query($registerQuery) === TRUE) {
            echo "<script>
            alert('Registration successful. Please log in.');
            window.location.href = 'login';
            </script>";
            exit();
        } else {
            echo "<script>
            alert('Error: " . $conn->error . "');
            window.location.href = 'login';
            </script>";
            exit();
        }
    }
}

if (isset($_POST['Login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['emailaddress']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $loginQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
    $result = $conn->query($loginQuery);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Check if user is blocked
        if ($row['status'] === 'blocked') {
            // Optionally delete the blocked user or just display a message
            echo "<script>
            alert('Your account is blocked. Please contact support.');
            window.location.href = 'login';
            </script>";
            exit();
        }

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_unique_id'] = $row['user_unique_id'];

            echo "<script>
            alert('Login successful');
            window.location.href = 'index';
            </script>";
            exit();
        } else {
            echo "<script>
            alert('Invalid password');
            window.location.href = 'login';
            </script>";
            exit();
        }
    } else {
        echo "<script>
        alert('No user found with this email');
        window.location.href = 'login';
        </script>";
        exit();
    }
}

$conn->close();
?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="admin/assets/images/favi.ico" type="image/x-icon">
    <script type="module" src="js/firebase.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .back-link {
  margin: 20px;
  background-color: #e84747;
  width: 131px;
  padding: 10px;
  color: white;
  font-weight: 500;
}
    </style>

</head>

<body>
<div class="back-link">
        <a href="index" class="btn btn-add">Back to Home</a>
    </div>

    <!-- -----------register------------ -->
    <div class="container" id="signup">
        <h1 class="form-title">Register</h1>
        <div id="signUpMessage" class="messageDiv" style="display:none;"></div>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="fName" name="name" placeholder="Enter Your Full Name" required>
                <label for="fName">Enter Full Name</label>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="rEmail" name="emailaddress" placeholder="Email" required>
                <label for="rEmail">Email</label>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="number" id="phone" name="phonenumber" placeholder="Enter Phone Number" required>
                <label for="phone">Phone Number</label>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="rPassword" name="password" placeholder="Password" required>
                <label for="rPassword">Password</label>
            </div>

            <button class="btn" name="Signup">Sign Up</button>
        </form>
        <p class="or">----------or----------</p>
        <!-- <div class="icons">
            <i class="fab fa-google" id="googleSignUp"></i>
            <i class="fab fa-facebook" id="facebookSignUp"></i>
        </div> -->
        <div class="links">
            <p>Already have an account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <!-- -----------login-------------------- -->
    <div class="container" id="signIn" style="display:none;">
        <h1 class="form-title">Sign In</h1>
        <div id="signInMessage" class="messageDiv" style="display:none;"></div>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" placeholder="Email" name="emailaddress" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" placeholder="Password" name="password" required>
                <label for="password">Password</label>
            </div>
            <!-- <p class="recover">
                <a href="#">Recover Password</a>
            </p> -->
            <button class="btn" name="Login">Sign In</button>
        </form>
        <p class="or">----------or----------</p>
        <!-- <div class="icons">
            <i class="fab fa-google" id="googleSignIn"></i>
            <i class="fab fa-facebook" id="facebookSignIn"></i>
        </div> -->
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>




    <script src="js/script.js"></script>
</body>

</html>
