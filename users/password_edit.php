<?php
session_start();
include('../connection.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['ChangePassword'])) {
    $user_id = $_SESSION['user_id'];
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $cnf_password = mysqli_real_escape_string($conn, $_POST['cnf_password']);

    if ($new_password !== $cnf_password) {
        echo "<script>
                alert('New password and confirm password do not match.');
                window.location.href = 'change_password';
              </script>";
        exit();
    }

    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    $checkPasswordQuery = "SELECT password FROM customer_register WHERE id=?";
    $stmt = $conn->prepare($checkPasswordQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($current_password, $row['password'])) {
            $updatePasswordQuery = "UPDATE customer_register SET password=? WHERE id=?";
            $stmt = $conn->prepare($updatePasswordQuery);
            $stmt->bind_param("si", $hashed_new_password, $user_id);
            if ($stmt->execute() === TRUE) {
                // Logout the user after changing the password
                session_destroy();
                echo "<script>
                        alert('Password changed successfully. Please log in with your new password.');
                        window.location.href = '../login';
                      </script>";
            } else {
                echo "<script>
                        alert('Error changing password: " . $conn->error . "');
                        window.location.href = 'change_password';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Current password is incorrect.');
                    window.location.href = 'change_password';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found.');
                window.location.href = '../login';
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
