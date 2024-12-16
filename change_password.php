<?php
session_start();
include "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match.'); window.history.back();</script>";
        exit;
    }

    // Fetch current password from database
    $query = "SELECT password FROM admin_register WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verify current password
    if (!password_verify($current_password, $row['password'])) {
        echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
        exit;
    }

    // Hash new password and update in database
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $update_query = "UPDATE admin_register SET password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $hashed_password, $user_id);
    $update_stmt->execute();

    echo "<script>alert('Password successfully changed.'); window.location.href='profile.php';</script>";
    exit;
}
?>
