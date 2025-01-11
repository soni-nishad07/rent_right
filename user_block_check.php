
<?php

if ($is_logged_in) {
    // Check if the user is blocked
    $user_id = $_SESSION['user_id'];
    $check_status_query = "SELECT status FROM customer_register WHERE id = '$user_id'";
    $result = $conn->query($check_status_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] === 'blocked') {
            // Destroy session and log the user out
            session_unset();
            session_destroy();
            echo "<script>
            alert('Your account has been blocked. Please contact support.');
            window.location.href = 'login';
            </script>";
            exit();
        }
    }
}

?>