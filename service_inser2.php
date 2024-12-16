<?php
include('connection.php');

// Function to generate unique booking ID
function generateBookingID() {
    return uniqid('booking_', true);
}

if (isset($_POST['book-visit'])) {
    $booking_id = generateBookingID(); // Generate unique booking ID
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    // $address = $_POST['address'];
    // $payment_mode = $_POST['payment_mode'];
    $booking_date = $_POST['booking_date'];
    $service_name = $_POST['service_name']; // Get the service name from the form
    $booking_status = $_POST['booking_status']; // Get the booking status from the form
    $submit_date = date("Y-m-d H:i:s"); // Get the current date and time


    $sql = "INSERT INTO bookings (booking_id, name, email, mobile,  booking_date, submit_date, service_name, booking_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $booking_id, $name, $email, $mobile,  $booking_date, $submit_date, $service_name, $booking_status);

    if ($stmt->execute()) {
        echo "<script>
        alert('Booking successful');
        window.location.href = 'services'; // Ensure this URL is correct
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
