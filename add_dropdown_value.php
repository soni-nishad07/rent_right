<?php
include('connection.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value = mysqli_real_escape_string($conn, $_POST['dropdown_value']);
    $query = "INSERT INTO dropdown_values (value) VALUES ('$value')";

    if (mysqli_query($conn, $query)) {
        $message = "Value added successfully";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

echo "<script type='text/javascript'>
        alert('$message');
        window.location.href = 'index.php';
      </script>";
?>
