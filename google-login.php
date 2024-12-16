<?php
require_once 'vendor/autoload.php';
include('connection.php');

session_start();

$client = new Google_Client();
$client->setClientId('228853359778-llh5uqf3dgqsuau294bmjekh83tcp0f5.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://wype.site/users/user-dashboard');
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = mysqli_real_escape_string($conn, $google_account_info->email);
    $name = mysqli_real_escape_string($conn, $google_account_info->name);
    $user_unique_id = uniqid('user_', true); // Generate a unique user ID
    $current_date = date('Y-m-d H:i:s'); // Get the current date and time

    // Check if the user is already registered
    $checkEmailQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows == 0) {
        // Register the user
        $registerQuery = "INSERT INTO customer_register (user_unique_id, name, emailaddress, phonenumber, password, `date`) VALUES ('$user_unique_id', '$name', '$email', '', '', '$current_date')";
        if ($conn->query($registerQuery) !== TRUE) {
            echo "<script>
            alert('Error: " . $conn->error . "');
            window.location.href = 'login';
            </script>";
            exit();
        }
    }

    // Fetch user details
    $loginQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
    $result = $conn->query($loginQuery);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_unique_id'] = $row['user_unique_id'];
    }

    // Redirect to dashboard or login page
    header('Location: users/user-dashboard');
    exit();
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
}
?>
