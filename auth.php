<?php
require 'vendor/autoload.php'; // Ensure Composer dependencies are loaded
require 'connection.php'; // Include database connection
session_start(); // Start the session

use Google\Client as Google_Client;

// Your Google Client ID
$CLIENT_ID = '228853359778-llh5uqf3dgqsuau294bmjekh83tcp0f5.apps.googleusercontent.com';

// Create a new Google client instance
$client = new Google_Client();
$client->setClientId($CLIENT_ID);
$client->addScope('profile');
$client->addScope('email');

// Get the token and action from the POST request
$idToken = $_POST['id_token'] ?? '';
$action = $_POST['action'] ?? ''; // 'register' or 'login'

$response = ['success' => false, 'message' => ''];

if ($idToken) {
    try {
        $payload = $client->verifyIdToken($idToken);
        if ($payload) {
            $userId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];

            if ($action === 'register') {
                // Check if user already exists
                $stmt = $conn->prepare("SELECT * FROM customer_register WHERE emailaddress = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $existingUser = $stmt->get_result()->fetch_assoc();

                if (!$existingUser) {
                    // Insert user into the database
                    $user_unique_id = $userId; // Use user ID from Google
                    $current_date = date('Y-m-d H:i:s');
                    $stmt = $conn->prepare("INSERT INTO customer_register (user_unique_id, name, emailaddress, phonenumber, password, `date`) VALUES (?, ?, ?, NULL, NULL, ?)");
                    $success = $stmt->execute([$user_unique_id, $name, $email, $current_date]);

                    if ($success) {
                        // Set session variables for user
                        $_SESSION['user_id'] = $user_unique_id;
                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'Database insert failed.';
                    }
                } else {
                    // User exists, set session variables and indicate success
                    $_SESSION['user_id'] = $existingUser['user_unique_id'];
                    $_SESSION['name'] = $existingUser['name'];
                    $_SESSION['email'] = $existingUser['emailaddress'];
                    
                    $response['success'] = true;
                }
            } elseif ($action === 'login') {
                // Check if user exists
                $stmt = $conn->prepare("SELECT * FROM customer_register WHERE emailaddress = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $existingUser = $stmt->get_result()->fetch_assoc();

                if ($existingUser) {
                    // Set session variables for user
                    $_SESSION['user_id'] = $existingUser['user_unique_id'];
                    $_SESSION['name'] = $existingUser['name'];
                    $_SESSION['email'] = $existingUser['emailaddress'];
                    
                    $response['success'] = true;
                } else {
                    $response['message'] = 'User not found.';
                }
            } else {
                $response['message'] = 'Invalid action.';
            }
        } else {
            $response['message'] = 'Invalid token.';
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'No token provided.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
