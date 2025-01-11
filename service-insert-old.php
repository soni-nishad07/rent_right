<?php
session_start();
include('connection.php');

// Function to generate unique booking ID
function generateBookingID() {
    return uniqid('booking_', true);
}

// Check if the form is submitted
if (isset($_POST['book-services'])) {
    $booking_id = generateBookingID(); 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $service_name = $_POST['service_name'];
    $booking_status = $_POST['booking_status'];
    $submit_date = date("Y-m-d H:i:s");

    // Insert query for users_bookings table
    $sql = "INSERT INTO bookings (booking_id, name, email, mobile, submit_date, service_name, booking_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $booking_id, $name, $email, $mobile, $submit_date, $service_name, $booking_status);

    // Execute query and handle redirection
    if ($stmt->execute()) {
        echo "<script>
        alert('Booking successful');
        window.location.href = 'home';
        </script>";
    } else {
        echo "<script>
        alert('Booking failed. Please try again.');
        window.location.href = '../index';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
