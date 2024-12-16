
<?php
session_start();
include('../connection.php'); // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $query = "INSERT INTO bhk_searches (name) VALUES ('$name')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'BHK added successfully!';
    } else {
        $_SESSION['message'] = 'Error adding BHK: ' . mysqli_error($conn);
    }

    header('Location: footer.php'); // Redirect to the page where the form is
    exit;
}
?>
