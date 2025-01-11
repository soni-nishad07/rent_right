<?php
session_start();
require_once('../connection.php');

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: index.php');
    exit;
}

$searchQuery = "";

// Handle search functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search']);
    $sqlSearch = "SELECT * FROM category WHERE property_choose LIKE '%$searchQuery%'";
    $result = $conn->query($sqlSearch);
} else {
    // Default query to display all categories
    $sqlSearch = "SELECT * FROM category";
    $result = $conn->query($sqlSearch);
}

// Handle form submission for inserting data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['property_type'])) {
    // Sanitize form inputs
    $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $bhk_type = isset($_POST['bhk_type']) ? mysqli_real_escape_string($conn, $_POST['bhk_type']) : null;

    $price_from = mysqli_real_escape_string($conn, $_POST['price_from']);
    $price_to = mysqli_real_escape_string($conn, $_POST['price_to']);

    // Handle property types
    $property_choose = [];
    if (isset($_POST['property_type_rent'])) {
        $property_choose[] = 'Rent';
    }
    if (isset($_POST['property_type_buy'])) {
        $property_choose[] = 'Buy';
    }
    if (isset($_POST['property_type_commercial'])) {
        $property_choose[] = 'Commercial';
    }

    // Combine property types into a string
    $property_choose_str = implode(", ", $property_choose);

    // Prepare the INSERT query with placeholders to avoid SQL injection
    if ($bhk_type) {
        $sql = "INSERT INTO category (property_choose, price_from, price_to, bhk_type) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $property_choose_str, $price_from, $price_to, $bhk_type);
    } else {
        $sql = "INSERT INTO category (property_choose, property_type, price_from, price_to) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdd", $property_choose_str, $property_type, $price_from, $price_to);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' id='alert'>New property added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' id='alert'>Error: " . $stmt->error . "</div>";
    }
    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent Right Bangalore</title>
    <?php include('admin-link.php'); ?>
    <style>
        /* Existing styles... */

        /* Popup styles */
        .popup {
            display: none;
            /* Hidden by default */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }

        .invoice-row {
            cursor: pointer;
            /* Style for rows, if needed */
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-file-text"></i>
                </div>

                <div class="header-title">
                    <h1>Category Add</h1>
                    <small> <br /> </small>
                    <div class="searchbar">
                        <form class="search-bar" method="POST" role="search">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search by Account" aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        </form>
                        <button type="button" class="btn-reset" onclick="window.location.href='category'">
                            <i class="fa fa-refresh home_reset" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="panel panel-bd panel-shadow">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <a href="#">
                                        <h4>Generate a new category </h4>
                                    </a>
                                </div>
                                <a href="category_list" class="btn btn-danger c-p-invoice">Check Previous category</a>
                            </div>
                            <div class="panel-body">
                                <form class="col-sm-10" method="POST" action="">
                                    <div class="form-group">
                                        <label>Select Property:</label><br>
                                        <input type="checkbox" id="property_type_rent" name="property_type_rent" value="Rent">
                                        <label for="property_type_rent">Rent</label><br>

                                        <input type="checkbox" id="property_type_buy" name="property_type_buy" value="Buy">
                                        <label for="property_type_buy">Buy</label><br>

                                        <input type="checkbox" id="property_type_commercial" name="property_type_commercial" value="Commercial">
                                        <label for="property_type_commercial">Commercial</label><br><br>
                                    </div>

                                    <!-- Property Name input field (always visible) -->
                                    <div class="form-group" id="property_name_field">
                                        <label for="property_type">Property Name:</label>
                                        <input type="text" id="property_type" name="property_type" class="form-control" placeholder="Property Name">
                                    </div>

                                    <!-- BHK Type input field (initially hidden) -->
                                    <div class="form-group" id="bhk_type_field" style="display: none;">
                                        <label for="bhk_type">BHK Type:</label>
                                        <input type="text" id="bhk_type" name="bhk_type" class="form-control" placeholder="BHK Type">
                                    </div>

                                    <!-- Rent Fields (Initially Hidden) -->
                                    <div class="form-group" id="rent_fields" style="display: none;">
                                        <label for="expected_rent_from">Expected Rent From:</label>
                                        <input type="number" id="expected_rent_from" name="expected_rent_from" class="form-control" placeholder="Rent From">
                                        <label for="expected_rent_to">Expected Rent To:</label>
                                        <input type="number" id="expected_rent_to" name="expected_rent_to" class="form-control" placeholder="Rent To">
                                    </div>

                                    <!-- Buy Fields (Initially Hidden) -->
                                    <div class="form-group" id="buy_fields" style="display: none;">
                                        <label for="expected_deposit_from">Expected Deposit From:</label>
                                        <input type="number" id="expected_deposit_from" name="expected_deposit_from" class="form-control" placeholder="Deposit From">
                                        <label for="expected_deposit_to">Expected Deposit To:</label>
                                        <input type="number" id="expected_deposit_to" name="expected_deposit_to" class="form-control" placeholder="Deposit To">
                                    </div>

                                    <!-- <div class="form-group">
                                        <label for="price_from">Price From:</label>
                                        <input type="number" id="price_from" name="price_from" class="form-control" placeholder="Price From" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="price_to">Price To:</label>
                                        <input type="number" id="price_to" name="price_to" class="form-control" placeholder="Price To" required>
                                    </div> -->

                                    <div class="ginvoice-submit-button">
                                        <input type="submit" class="btn btn-danger w-100" value="Add Category">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script>
                // Toggle visibility of the BHK type field based on the 'Rent' checkbox
                document.getElementById("property_type_rent").addEventListener("change", function() {
                    var bhkField = document.getElementById("bhk_type_field");
                    var propertyNameField = document.getElementById("property_name_field");
                    document.getElementById("property_name_field").style.display = "none";

                    if (this.checked) {
                        bhkField.style.display = "block"; // Show the BHK type input field
                        rentFields.style.display = "block"; // Show rent fields
                    } else {
                        bhkField.style.display = "none";
                        // Hide the BHK type input field
                        document.getElementById("property_name_field").style.display = "block";
                    }
                });

                // Toggle visibility of the BHK field based on the selected checkboxes
                document.getElementById("property_type_buy").addEventListener("change", function() {
                    document.getElementById("bhk_type_field").style.display = "none"; // Hide the BHK field when 'Buy' is selected
                    document.getElementById("property_name_field").style.display = "block";

                });
                document.getElementById("property_type_commercial").addEventListener("change", function() {
                    document.getElementById("bhk_type_field").style.display = "none"; // Hide the BHK field when 'Commercial' is selected
                    document.getElementById("property_name_field").style.display = "block";
                });
            </script>

        </div>


        <div class="control-sidebar-bg"></div>
    </div>



    <script>
        setTimeout(function() {
            var alertElement = document.getElementById('alert');
            if (alertElement) {
                alertElement.style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>




    <!-- footer copyright -->
    <?php
    // include('../copyright.php');
    ?>

    <?php include('footer-link.php'); ?>

</body>

</html>