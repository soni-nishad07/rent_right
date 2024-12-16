<?php
include('connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : null;

    // Check if the user already exists
    $checkEmailQuery = "SELECT * FROM customer_register WHERE emailaddress='$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // User exists, log them in
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_unique_id'] = $row['user_unique_id'];

        echo json_encode(['message' => 'Login successful', 'redirect' => 'users/user-dashboard']);
    } else {
        // User doesn't exist, register them
        $user_unique_id = uniqid('user_', true);
        $current_date = date('Y-m-d H:i:s'); // Get the current date and time

        $registerQuery = "INSERT INTO customer_register (user_unique_id, name, emailaddress, date) VALUES ('$user_unique_id', '$name', '$email', '$current_date')";
        if ($conn->query($registerQuery) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id; // Get the last inserted ID
            $_SESSION['user_name'] = $name;
            $_SESSION['user_unique_id'] = $user_unique_id;

            echo json_encode(['message' => 'Registration successful. Please log in.', 'redirect' => 'users/user-dashboard']);
        } else {
            echo json_encode(['message' => 'Error: ' . $conn->error]);
        }
    }
} else {
    echo json_encode(['message' => 'Invalid request.']);
}

$conn->close();
?>
