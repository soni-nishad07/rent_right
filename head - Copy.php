<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with jQuery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .rent-head {
            background-color: #f8f9fa;
            padding: 10px 0;
        }

        .btn-secondary1 {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-secondary1:hover {
            background-color: #0056b3;
        }

        .dropdown-menu {
            z-index: 1050;
            /* Ensures dropdowns appear above other elements */
        }

        .logo-img {
            max-width: 100px;
        }

        .sign_contact-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .sign_contact-button:hover {
            background-color: #0056b3;
        }




        /* --------------------DROPDOWN------------------- */

.commercial-dropdown
{
        /* position: absolute; */
        inset: 0px auto auto 0px;
    margin: 0px;
    transform: translate3d(100.5px, 25px, 0px) !important;
    display: block;
}


        
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light rent-head">
        <div class="container-fluid">

            <a href="index" class="navbar-brand">
                <img src="./icons/Logo.png" alt="Rent Right Bangalore" class="logo-img">
            </a>

            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index#our_service">Our Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact">Contact Us</a>
                    </li>
                    <!-- <li class="nav-item">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <a class="nav-link" href="users/post-property">Post  Property</a>
                    <?php else: ?>
                        <a class="nav-link" href="users/property">Post Free Property</a>
                    <?php endif; ?>
                </li> -->

                    <li class="nav-item">
                        <?php if (isset($_SESSION['user_name'])): ?>
                            <a class="nav-link" href="users/post-property"><b>Post Property</b></a>
                        <?php else: ?>
                            <a class="nav-link" href="login">Post Free Property</a>
                        <?php endif; ?>
                    </li>
                </ul>

                <div class="d-flex">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <div class="dropdown">
                            <a class="btn dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="index">Home</a></li>
                                <li><a class="dropdown-item" href="users/enquiries">Requests Received</a></li>
                                <li><a class="dropdown-item" href="users/saved">Saved</a></li>
                                <li><a class="dropdown-item" href="users/Property_list">Property Listing</a></li>
                                <li><a class="dropdown-item" href="users/Property_all_list">All Property Listing</a></li>
                                <li><a class="dropdown-item" href="users/UserProfile">Update Profile</a></li>
                                <li><a class="dropdown-item" href="users/chngepswd">Change Password</a></li>
                                <li><a class="dropdown-item" href="logout">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login">
                            <button class="sign_contact-button me-2">Login / Sign Up</button>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
<!-- ------------------------- -->





<?php
// Fetch distinct bhk_type options for Rent
$bhk_query1 = "SELECT DISTINCT bhk_type FROM category WHERE bhk_type IS NOT NULL AND property_choose LIKE '%Rent%'";
$bhk_result1 = $conn->query($bhk_query1);

// Fetch distinct property types for Buy
$buy_query = "SELECT DISTINCT property_type FROM category WHERE property_choose LIKE '%Buy%'";
$buy_result = $conn->query($buy_query);

// Fetch distinct property types for Commercial
$commercial_query = "SELECT DISTINCT property_type FROM category WHERE property_choose LIKE '%Commercial%'";
$commercial_result = $conn->query($commercial_query);
?>

<div class="container-fluid rent-head d-flex">
    <!-- Rent Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='index'">Rent</button>
        <button class="btn btn-secondary1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" id="rent-dropdown">
            <?php
            // Display BHK options for Rent
            if ($bhk_result1->num_rows > 0) {
                while ($row = $bhk_result1->fetch_assoc()) {
                    $bhkType = htmlspecialchars($row['bhk_type']);
                    echo "<li><button class='dropdown-item' type='button' onclick=\"redirectToRent('$bhkType')\">$bhkType</button></li>";
                }
            } else {
                echo "<li><span class='dropdown-item disabled'>No BHK options available</span></li>";
            }
            ?>
        </ul>
    </div>

    <!-- Buy Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='home'">Buy</button>
        <button class="btn btn-secondary1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" id="buy-dropdown">
            <?php
            // Display property types for Buy
            if ($buy_result->num_rows > 0) {
                while ($row = $buy_result->fetch_assoc()) {
                    $propertyType = htmlspecialchars($row['property_type']);
                    echo "<li><button class='dropdown-item' type='button' onclick=\"redirectToBuy('$propertyType')\">$propertyType</button></li>";
                }
            } else {
                echo "<li><span class='dropdown-item disabled'>No property types available</span></li>";
            }
            ?>
        </ul>
    </div>

    <!-- Commercial Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='home1'">Commercial</button>
        <button class="btn btn-secondary1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" id="commercial-dropdown">
            <?php
            // Display property types for Commercial
            if ($commercial_result->num_rows > 0) {
                while ($row = $commercial_result->fetch_assoc()) {
                    $propertyType = htmlspecialchars($row['property_type']);
                    echo "<li><button class='dropdown-item' type='button' onclick=\"redirectToCommercial('$propertyType')\">$propertyType</button></li>";
                }
            } else {
                echo "<li><span class='dropdown-item disabled'>No property types available</span></li>";
            }
            ?>
        </ul>
    </div>
</div>

<!-- JavaScript for Dynamic Redirection -->
<script>
    // Redirect based on Rent Option
    function redirectToRent(bhkType) {
        const normalizedBhk = bhkType.replace(/\s+/g, '').toUpperCase();
        // window.location.href = `users/propertyDetails.php?bhk_type=${normalizedBhk}&available_for=Rent`;
        window.location.href = `users/headpropertyDetails.php?bhk_type=${normalizedBhk}&available_for=Rent`;
    }

    // Redirect based on Buy Option
    function redirectToBuy(buyType) {
        const normalizedBuy = buyType.replace(/\s+/g, '').toUpperCase();
        // window.location.href = `users/propertyDetails.php?buy_type=${normalizedBuy}&available_for=Buy`;
             window.location.href = `users/headpropertyDetails.php?buy_type=${normalizedBuy}&available_for=Buy`;   
    }

    // Redirect based on Commercial Option
    function redirectToCommercial(commercialType) {
        const normalizedCommercial = commercialType.replace(/\s+/g, '').toUpperCase();
        // window.location.href = `users/propertyDetails.php?commercial_type=${normalizedCommercial}&available_for=Commercial`;
        window.location.href = `users/headpropertyDetails.php?commercial_type=${normalizedCommercial}&available_for=Commercial`;
    }
</script>




    <!-- JavaScript for Dynamic Redirection -->
    <script>
        function redirectToPage(bhkType) {
            const normalizedBHK = bhkType.replace(/\s+/g, '').toUpperCase();
            window.location.href = `users/headpropertyDetails.php?bhk_type=${normalizedBHK}&available_for=Rent`;
        }

        function redirectToPage2(propertyType) {
            const normalizedProperty = propertyType.replace(/\s+/g, '').toUpperCase();
            window.location.href = `users/headpropertyDetails.php?property_type=${normalizedProperty}&available_for=Sale`;
        }
    </script>



    <script>
        $(document).ready(function() {
            // Navbar toggle animation
            $(".navbar-toggler").click(function() {
                $("#navbarSupportedContent").slideToggle();
            });

            // Dropdown menu toggle behavior
            $(".dropdown-toggle").click(function(e) {
                e.stopPropagation(); // Prevent conflicts
                $(this).next(".dropdown-menu").slideToggle();
            });

            // Close dropdown menus when clicking outside
            $(document).click(function() {
                $(".dropdown-menu").slideUp();
            });

            // Prevent dropdown closing when clicking inside the menu
            $(".dropdown-menu").click(function(e) {
                e.stopPropagation();
            });
        });
    </script>

</body>

</html>