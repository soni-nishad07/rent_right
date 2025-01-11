<?php

include('../connection.php');

// Fetch data
$sql = "SELECT MONTH(booking_date) as month, COUNT(*) as total_order, SUM(CASE WHEN booking_status = 'complete' THEN 1 ELSE 0 END) as complete FROM bookings GROUP BY MONTH(booking_date)";
$result = $conn->query($sql);

$data = array();
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
