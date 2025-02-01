
<!-- ------------------------------------------------------------------------------------------- -->
 <!-- --------------------------------------------------------------------------- -->

 <?php


$is_logged_in = isset($_SESSION['user_id']); // Check if user_id exists in the session



if ($is_logged_in) {
    // Check if the user is blocked
    $user_id = $_SESSION['user_id'];
    $check_status_query = "SELECT status FROM customer_register WHERE id = '$user_id'";
    $result = $conn->query($check_status_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] === 'blocked') {
            // Destroy session and log the user out
            session_unset();
            session_destroy();
            echo "<script>
            alert('Your account has been blocked. Please contact support.');
            window.location.href = '../login';
            </script>";
            exit();
        }
    }
}


?>




 <nav class="navbar navbar-expand-lg navbar-light rent-head">
    <div class="container-fluid">

        <a href="../index" class="navbar-brand">
            <img src="Logo.png" alt="Rent Right Bangalore" class="logo-img">
        </a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../about">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../index#our_service">Our Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../contact">Contact Us</a>
                </li>
          
                <!-- <li class="nav-item">
                     <?php 
                        $current_url = $_SERVER['REQUEST_URI'];
                                $post_property_url = "/users/post-property";
                    ?>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <?php if (str_ends_with($current_url, $post_property_url)): ?>
                            <a class="nav-link" href="property">Post Free Property</a>
                        <?php else: ?>
                            <a class="nav-link" href="post-property">Post  Property</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a class="nav-link" href="../login">Post  Free Property</a>
                    <?php endif; ?>
                </li> -->


                  <li class="nav-item">
                     <?php 
                        $current_url = $_SERVER['REQUEST_URI'];
                        $post_property_url = "/users/post-property";
                    ?>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <?php if (str_ends_with($current_url, $post_property_url)): ?>
                            <a class="nav-link" href="property"><b>Post Free Property</b></a>
                        <?php else: ?>
                            <a class="nav-link" href="post-property"><b>Post  Property</b></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a class="nav-link" href="../login"><b>Post Free Property</b></a>
                    <?php endif; ?>
                </li>
            </ul>

            <div class="d-flex">
                <?php if(isset($_SESSION['user_name'])): ?>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="../index">Home</a></li>
                            <li><a class="dropdown-item" href="enquiries">Requests Received</a></li>
                            <li><a class="dropdown-item" href="saved">Saved</a></li>
                            <li><a class="dropdown-item" href="Property_list">Property Listing</a></li>
                            <li><a class="dropdown-item" href="Property_all_list">All Property Listing</a></li>
                            <li><a class="dropdown-item" href="UserProfile">Update Profile</a></li>
                            <li><a class="dropdown-item" href="chngepswd">Change Password</a></li>
                            <li><a class="dropdown-item" href="../logout">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="../login">
                        <button class=" sign_contact-button me-2">Login / Sign Up</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>




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
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='../index'">Rent</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu" id="rent-dropdown">
            <?php
            // Display BHK options for Rent
            if ($bhk_result1->num_rows > 0) {
                while ($row = $bhk_result1->fetch_assoc()) {
                    $bhkType = htmlspecialchars($row['bhk_type']);
                    echo "<li><button class='dropdown-item' type='button' onclick=\"redirectToPage('$bhkType')\">$bhkType</button></li>";
                }
            } else {
                echo "<li><span class='dropdown-item disabled'>No BHK options available</span></li>";
            }
            ?>
        </ul>
    </div>

    <!-- Buy Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='../home'">Buy</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu" id="buy-dropdown">
            <?php
            // Display property types for Buy
            if ($buy_result->num_rows > 0) {
                while ($row = $buy_result->fetch_assoc()) {
                    $propertyType = htmlspecialchars($row['property_type']);
                    echo "<li><button class='dropdown-item' type='button' onclick=\"redirectToPage2('$propertyType')\">$propertyType</button></li>";
                }
            } else {
                echo "<li><span class='dropdown-item disabled'>No property types available</span></li>";
            }
            ?>
        </ul>
    </div>

    <!-- Sale Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='../home1'">Commercial</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu" id="commercial-dropdown">
            <?php
            // Display property types for Commercial
            if ($commercial_result->num_rows > 0) {
                while ($row = $commercial_result->fetch_assoc()) {
                    $propertyType = htmlspecialchars($row['property_type']);
                    echo "<li><button class='dropdown-item' type='button' onclick=\"redirectToPage3('$propertyType')\">$propertyType</button></li>";
                }
            } else {
                echo "<li><span class='dropdown-item disabled'>No property types available</span></li>";
            }
            ?>
        </ul>
    </div> 

    <!-- JavaScript for Dynamic Redirection -->
    <script>
        // Redirect based on BHK Type for Rent
        function redirectToPage(bhkType) {
            const normalizedBHK = bhkType.replace(/\s+/g, '').toUpperCase(); // Normalize text
            window.location.href = `rent_headpropertyDetails.php?bhk_type=${normalizedBHK}&available_for=Rent`;
        }

        // Redirect based on Property Type for Sale
        function redirectToPage2(propertyType) {
            const normalizedProperty = propertyType.replace(/\s+/g, '').toUpperCase(); // Normalize text
            window.location.href = `headpropertyDetails.php?property_type=${normalizedProperty}&available_for=Sale`;
        }

        function redirectToPage3(propertyType) {
            const normalizedProperty = propertyType.replace(/\s+/g, '').toUpperCase();
            window.location.href = `commercial_headpropertyDetails.php?property_type=${normalizedProperty}&available_for=Sale`;
        }

    </script>
</div>