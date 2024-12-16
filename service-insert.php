

<?php
session_start();
include('connection.php');

// Function to generate unique booking ID
function generateBookingID() {
    return uniqid('booking_', true);
}

// Check if the form is submitted
if (isset($_POST['book-visit'])) {
    $booking_id = generateBookingID(); 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $booking_date = $_POST['booking_date'];
    $service_name = $_POST['service_name'];
    $booking_status = $_POST['booking_status'];
    $submit_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO bookings (booking_id, name, email, mobile, booking_date, submit_date, service_name, booking_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $booking_id, $name, $email, $mobile, $booking_date, $submit_date, $service_name, $booking_status);

    if ($stmt->execute()) {
        echo "<script>
        alert('Booking successful');
        window.location.href = 'home';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// $is_logged_in = isset($_SESSION['user_id']);

?>