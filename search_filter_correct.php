<?php
session_start();
include('connection.php');

$is_logged_in = isset($_SESSION['user_id']); // Check if user is logged in

// Sanitize function to prevent SQL Injection
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Initialize an empty error message
$error_message = '';

if (isset($_POST['search'])) {
    $location = sanitize($_POST['location'] ?? '');
    $bhkType = sanitize($_POST['bhk_type'] ?? '');
    $priceRange = sanitize($_POST['expected_deposit'] ?? '');

    $query = "SELECT * FROM properties WHERE 1=1";

    // Add conditions to the query based on input values
    if (!empty($location)) {
        $query .= " AND city LIKE '%$location%'";
    }
    if (!empty($bhkType)) {
        $query .= " AND REPLACE(bhk_type, ' ', '') = REPLACE('$bhkType', ' ', '')";
    }
    if (!empty($priceRange)) {
        if (strpos($priceRange, '-') !== false) {
            list($minPrice, $maxPrice) = explode('-', $priceRange);
            $maxPrice = ($maxPrice == 'above') ? 9999999 : $maxPrice;  // Handle 'above' as upper bound
            $query .= " AND expected_deposit BETWEEN $minPrice AND $maxPrice";
        }
    }

    // Execute query
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<script>window.location.href = 'home.php';</script>";
    } else {
        // Set error message if no results are found
        $error_message = "No properties found based on your search criteria.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Right Bangalore</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="admin/assets/images/favi.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places">
</script>    <?php include('links.php'); ?>
</head>

<body>
    <?php include('head.php'); ?>

    <header class="header">
        <div class="header-content">
            <h2>Making Home Rentals and Services Easy and Reliable</h2>
            <p>From finding a home to maintaining it, we've got you covered.</p>
        </div>

        <div class="search-bar rent_search_bar">
            <h3>What Do you need?</h3>

            <form action="search_property.php" method="POST" class="search-form">
                <input type="text" id="location-input" name="location" placeholder="Enter a location" required />

                <select name="bhk_type" required>
                    <option value="">BHK Type</option>
                    <option value="1 BHK">1 BHK</option>
                    <option value="2 BHK">2 BHK</option>
                    <option value="3 BHK">3 BHK</option>
                    <option value="4 BHK">4 BHK</option>
                    <option value="5 BHK">5 BHK</option>
                    <option value="Independent House">Independent House</option>
                    <option value="1 RK">1 RK</option>
                    <option value="Commercial Space">Commercial Space</option>
                    <option value="Land">Land</option>
                    <option value="Complete Building">Complete Building</option>
                    <option value="Bungalow">Bungalow</option>
                    <option value="Villa">Villa</option>
                </select>

                <select name="expected_deposit" required>
                    <option value="">Select Expected Deposit</option>
                    <option value="5000-10000">5,000 - 10,000</option>
                    <option value="10000-30000">10,000 - 30,000</option>
                    <option value="30000-50000">30,000 - 50,000</option>
                    <option value="50000-100000">50,000 - 100,000</option>
                    <option value="100000-150000">100,000 - 150,000</option>
                    <option value="150000-200000">150,000 - 200,000</option>
                    <option value="200000-250000">200,000 - 250,000</option>
                    <option value="250000-300000">250,000 - 300,000</option>
                    <option value="300000-350000">300,000 - 350,000</option>
                    <option value="350000-400000">350,000 - 400,000</option>
                    <option value="400000-450000">400,000 - 450,000</option>
                    <option value="450000-480000">450,000 - 480,000</option>
                    <option value="480000-500000">480,000 - 500,000</option>
                    <option value="500000-above">500,000 - Above</option>
                </select>

                <button type="submit" name="search" class="search-button">Search</button>
            </form>

            <!-- Error message display area -->
            <div id="error-message" style="color: red; <?php if (empty($error_message)) echo 'display: none;' ?>">
                <?php echo $error_message; ?>
            </div>
        </div>
    </header>

    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        // JavaScript to hide the error message after a few seconds
        $(document).ready(function () {
            if ($('#error-message').text().trim() !== '') {
                setTimeout(function () {
                    $('#error-message').fadeOut('slow');
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>
</body>
</html>
