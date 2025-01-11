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
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $service_name = htmlspecialchars(trim($_POST['service_name']));
    $booking_status = htmlspecialchars(trim($_POST['booking_status']));
    $submit_date = date("Y-m-d H:i:s");

    // Validate input fields
    if (!empty($name) && !empty($email) && !empty($mobile) && !empty($service_name) && !empty($booking_status)) {
        // Insert query for users_bookings table
        $sql = "INSERT INTO bookings (booking_id, name, email, mobile, submit_date, service_name, booking_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $booking_id, $name, $email, $mobile, $submit_date, $service_name, $booking_status);

        // Execute query and handle redirection
        if ($stmt->execute()) {
            echo "<script>
            alert('Booking successful');
            window.location.href = 'index';
            </script>";
        } else {
            echo "<script>
            alert('Booking failed. Please try again.');
            window.location.href = 'index';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
        alert('All fields are required. Please fill in all details.');
        window.location.href = 'index';
        </script>";
    }
    
    $conn->close();
}
?>