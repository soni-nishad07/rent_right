<?php
// Include database connection
include('connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into database
    $query = "INSERT INTO contact_messages (name, email, mobile, message) 
              VALUES ('$name', '$email', '$mobile', '$message')";

    if (mysqli_query($conn, $query)) {
        // Redirect to a confirmation page or back to the form with a success message
        echo "<script>
                alert('Message sent successfully!');
                window.location.href = 'contact.php';  // Replace with your desired URL or page
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.location.href = 'contact.php';  // Redirect back to form on error
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request method!');
            window.location.href = 'contact.php';  // Redirect to form if method is invalid
          </script>";
}
?>
