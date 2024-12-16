<?php
include('../connection.php');


if (isset($_POST['EditProfile'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['emailaddress']);
    $phone = mysqli_real_escape_string($conn, $_POST['phonenumber']);

    $updateQuery = "UPDATE customer_register SET name='$name', emailaddress='$email', phonenumber='$phone' WHERE id='$id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_phone'] = $phone;
        echo "<script>
                alert('Profile updated successfully.');
                window.location.href = 'user-dashboard';
              </script>";
    } else {
        echo "<script>
                alert('Error updating profile: " . $conn->error ."');
                window.location.href = 'user-dashboard';
              </script>";
    }
}

$conn->close();
?>
