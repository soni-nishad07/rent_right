<?php
require_once 'vendor/autoload.php';
include('connection.php');

session_start();

// $client = new Google_Client();
// $client->setClientId('228853359778-llh5uqf3dgqsuau294bmjekh83tcp0f5.apps.googleusercontent.com');
// $client->setClientSecret('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');
// $client->setRedirectUri('https://wype.site/users/user-dashboard');
// $client->addScope("email");
// $client->addScope("profile");

// if (isset($_GET['code'])) {
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $client->setAccessToken($token);

//     // get profile info
//     $google_oauth = new Google_Service_Oauth2($client);
//     $google_account_info = $google_oauth->userinfo->get();
//     $email = mysqli_real_escape_string($conn, $google_account_info->email);
//     $name = mysqli_real_escape_string($conn, $google_account_info->name);
//     $user_unique_id = uniqid('user_', true); // Generate a unique user ID
//     $current_date = date('Y-m-d H:i:s'); // Get the current date and time

//     // Check if the user is already registered
//     $checkEmailQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
//     $result = $conn->query($checkEmailQuery);

//     if ($result->num_rows == 0) {
//         // Register the user
//         $registerQuery = "INSERT INTO customer_register (user_unique_id, name, emailaddress, phonenumber, password, `date`) VALUES ('$user_unique_id', '$name', '$email', '', '', '$current_date')";
//         if ($conn->query($registerQuery) !== TRUE) {
//             echo "<script>
//             alert('Error: " . $conn->error . "');
//             window.location.href = 'login';
//             </script>";
//             exit();
//         }
//     }

//     // Fetch user details
//     $loginQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
//     $result = $conn->query($loginQuery);
//     if ($result->num_rows == 1) {
//         $row = $result->fetch_assoc();
//         $_SESSION['user_id'] = $row['id'];
//         $_SESSION['user_name'] = $row['name'];
//         $_SESSION['user_unique_id'] = $row['user_unique_id'];
//     }

//     // Redirect to dashboard or login page
//     header('Location: users/user-dashboard');
//     exit();
// } else {
//     $auth_url = $client->createAuthUrl();
//     header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
//     exit();
// }
?>











<?php
require_once 'vendor/autoload.php';
include('connection.php');

session_start();
 

// init configuration
$clientID = '228853359778-llh5uqf3dgqsuau294bmjekh83tcp0f5.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://wype.site/users/user-dashboard';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  // now you can use this profile info to create account in your website and make user logged in.
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
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
    <?php include('links.php'); ?>
</head>

<body>
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
        <div class="icons">
            <i class="fab fa-google" id="googleSignUp"></i>
            <i class="fab fa-facebook" id="facebookSignUp"></i>
        </div>
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
        <div class="icons">
            <i class="fab fa-google" id="googleSignIn"></i>
            <i class="fab fa-facebook" id="facebookSignIn"></i>
        </div>
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>

</html>

