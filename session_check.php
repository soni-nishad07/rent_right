<?php
session_start();

// Check if the user is logged in and their user type
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_type'], ['Owner', 'User', 'Broker'])) {
    header('Location: ../login.php');
    exit();
}

// Now you can check the user type for further actions if necessary
switch ($_SESSION['user_type']) {
    case 'Owner':
        // Code for Owner
        break;
    
    case 'User':
        // Code for User
        break;

    case 'Broker':
        // Code for Broker
        break;
}
?>
