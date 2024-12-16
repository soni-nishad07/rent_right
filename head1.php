


<nav class="navbar navbar-expand-lg navbar-light rent-head">
    <div class="container-fluid">

        <a href="index" class="navbar-brand">
            <img src="./icons/Logo.png" alt="Rent Right Bangalore" class="logo-img">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="contact">Contact Us</a>
                </li>
                <li class="nav-item">
                    <?php if(isset($_SESSION['user_name'])): ?>
                        <a class="nav-link" href="users/post-property">Post Free Property</a>
                    <?php else: ?>
                        <a class="nav-link" href="users/property">Post Property</a>
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
                        <button class=" sign_contact-button me-2">Login / Sign Up</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid rent-head">
    <!-- Rent Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='index'">Rent</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button">1 BHK</button></li>
            <li><button class="dropdown-item" type="button">2 BHK</button></li>
            <li><button class="dropdown-item" type="button">3 BHK</button></li>
            <li><button class="dropdown-item" type="button">4 BHK</button></li>
            <li><button class="dropdown-item" type="button">5 BHK</button></li>
            <li><button class="dropdown-item" type="button">1 RK</button></li>
            <li><button class="dropdown-item" type="button">Commercial Space</button></li>
            <li><button class="dropdown-item" type="button">Land</button></li>
            <li><button class="dropdown-item" type="button">Complete Building</button></li>
            <li><button class="dropdown-item" type="button">Bungalow</button></li>
            <li><button class="dropdown-item" type="button">Villa</button></li>
        </ul>
    </div>

    <!-- Buy Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='home'">Buy</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button">Flat</button></li>
            <li><button class="dropdown-item" type="button">Building</button></li>
            <li><button class="dropdown-item" type="button">Site</button></li>
            <li><button class="dropdown-item" type="button">Commercial</button></li>
            <li><button class="dropdown-item" type="button">Villa</button></li>
        </ul>
    </div>

    <!-- Sale Dropdown -->
    <div class="dropdown">
        <button class="btn btn-secondary1" type="button" onclick="window.location.href='home1'">Sale</button>
        <button class="btn btn-secondary1 dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden"></span>
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" type="button">Flat</button></li>
            <li><button class="dropdown-item" type="button">Building</button></li>
            <li><button class="dropdown-item" type="button">Site</button></li>
            <li><button class="dropdown-item" type="button">Commercial</button></li>
            <li><button class="dropdown-item" type="button">Villa</button></li>
        </ul>
    </div> 
</div>




