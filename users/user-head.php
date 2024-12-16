
<!-- ------------------------------------------------------------------------------------------- -->
 <!-- --------------------------------------------------------------------------- -->


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
                            <a class="nav-link" href="property">Post Free Property</a>
                        <?php else: ?>
                            <a class="nav-link" href="post-property">Post  Property</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a class="nav-link" href="../login">Post  Free Property</a>
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



<div class="container-fluid rent-head d-flex">
    <!-- Rent Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='../index'">Rent</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu" id="rent-dropdown">
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('1BHK')">1 BHK</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('2BHK')">2 BHK</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('3BHK')">3 BHK</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('4BHK')">4 BHK</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('5BHK')">5 BHK</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('1RK')">1 RK</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('CommercialSpace')">Commercial Space</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('Land')">Land</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('CompleteBuilding')">Complete Building</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('Bungalow')">Bungalow</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage('Villa')">Villa</button></li>
        </ul>
    </div>

    <!-- Buy Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='../home'">Buy</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Flat')">Flat</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Building')">Building</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Site')">Site</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Commercial')">Commercial</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Villa')">Villa</button></li>
        </ul>
    </div>

    <!-- Sale Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='../home1'">Commercial</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Flat')">Flat</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Building')">Building</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Site')">Site</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Commercial')">Commercial</button></li>
            <li><button class="dropdown-item" type="button" onclick="redirectToPage2('Villa')">Villa</button></li>
        </ul>
    </div> 

    <!-- JavaScript for Dynamic Redirection -->
    <script>
        // Redirect based on BHK Type for Rent
        function redirectToPage(bhkType) {
            const normalizedBHK = bhkType.replace(/\s+/g, '').toUpperCase(); // Normalize text
            window.location.href = `headpropertyDetails.php?bhk_type=${normalizedBHK}&available_for=Rent`;
        }

        // Redirect based on Property Type for Sale
        function redirectToPage2(propertyType) {
            const normalizedProperty = propertyType.replace(/\s+/g, '').toUpperCase(); // Normalize text
            window.location.href = `headpropertyDetails.php?property_type=${normalizedProperty}&available_for=Sale`;
        }
    </script>
</div>