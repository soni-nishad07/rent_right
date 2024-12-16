<?php
require_once 'vendor/autoload.php';
include('connection.php');
session_start();

$fb = new \Facebook\Facebook([
    'app_id' => '419239481143879', // Your Facebook App ID
    'app_secret' => '277aadce95d49ee0a03eb2cdc6d9fa61', // Your Facebook App Secret
    'default_graph_version' => 'v13.0',
]);

$helper = $fb->getRedirectLoginHelper();

if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

try {
    $accessToken = $helper->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    echo "<script>
        alert('Graph returned an error: " . addslashes($e->getMessage()) . "');
        window.location.href = 'login';
        </script>";
    exit();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo "<script>
        alert('Facebook SDK returned an error: " . addslashes($e->getMessage()) . "');
        window.location.href = 'login';
        </script>";
    exit();
}

if (!isset($accessToken)) {
    echo "<script>
        alert('Error: " . addslashes($helper->getError()) . "');
        window.location.href = 'login';
        </script>";
    exit();
}

$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId('419239481143879');
$tokenMetadata->validateExpiration();

if (!$accessToken->isLongLived()) {
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo "<script>
            alert('Error getting long-lived access token: " . addslashes($e->getMessage()) . "');
            window.location.href = 'login';
            </script>";
        exit();
    }
}

$_SESSION['fb_access_token'] = (string) $accessToken;

try {
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $user = $response->getGraphUser();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    echo "<script>
        alert('Graph returned an error: " . addslashes($e->getMessage()) . "');
        window.location.href = 'login';
        </script>";
    exit();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo "<script>
        alert('Facebook SDK returned an error: " . addslashes($e->getMessage()) . "');
        window.location.href = 'login';
        </script>";
    exit();
}

$email = mysqli_real_escape_string($conn, $user['email']);
$name = mysqli_real_escape_string($conn, $user['name']);
$user_unique_id = uniqid('user_', true);
$current_date = date('Y-m-d H:i:s');

$checkEmailQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
$result = $conn->query($checkEmailQuery);

if ($result->num_rows == 0) {
    $registerQuery = "INSERT INTO customer_register (user_unique_id, name, emailaddress, phonenumber, password, `date`) VALUES ('$user_unique_id', '$name', '$email', '', '', '$current_date')";
    if ($conn->query($registerQuery) !== TRUE) {
        echo "<script>
            alert('Error: " . addslashes($conn->error) . "');
            window.location.href = 'login';
            </script>";
        exit();
    }
}

$loginQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
$result = $conn->query($loginQuery);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_unique_id'] = $row['user_unique_id'];

    echo "<script>
        alert('Login successful');
        window.location.href = 'users/user-dashboard';
        </script>";
    exit();
} else {
    echo "<script>
        alert('No user found with this email');
        window.location.href = 'login';
        </script>";
    exit();
}
?>
