

<head>
<link rel="stylesheet" href="../css/responsive.css"> 
</head>

<header>
    <div class="container">
        <div class="row">

                <div class="logo">
                    <a href="../index">
                        <img src="../icons/Logo.png" alt="Rent Right Bangalore">
                    </a>
                </div>


                <div class="search-bar">
                <input type="search" id="searchInput" placeholder="Search" onkeyup="checkEnter(event)">
                    <div class="explore-dropdown" onclick="toggleDropdown()">Explore▼</div>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <?php
                        $query = "SELECT * FROM dropdown_values";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $link = '';
                                switch ($row['value']) {
                                    case 'Rent':
                                        $link = '../index.php';
                                        break;
                                    case 'Sale':
                                        $link = '../home2.php';
                                        break;
                                    case 'Commercial':
                                        $link = '../home3.php';
                                        break;
                                    default:
                                        $link = '../services2.php?service=' . urlencode($row['value']);
                                        break;
                                }
                                echo '<a href="' . $link . '">' . htmlspecialchars($row['value']) . '</a>';
                            }
                        } else {
                            echo '<a href="#">No services available</a>';
                        }
                        ?>
                        <a href="../services2.php" style="color: #ff594e;">See All</a>
                    </div>
                </div>


                <nav class="menu">
                    <?php if(isset($_SESSION['user_name'])): ?>
                    <a href="post-property">Post Property</a>
                    <?php else: ?>
                    <a href="property">Post Free Property</a>
                    <?php endif; ?>
                </nav>






                <div class="login-header">
                <?php if(isset($_SESSION['user_name'])): ?>
                <div class="dropdown">
                    <a class="btn  dropdown-toggle" href="#" role="button" id="secondaryDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['user_name']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="secondaryDropdown">
                        <li><a class="dropdown-item" href="user-dashboard">Home</a></li>
                        <li><a class="dropdown-item" href="enquiries"> Requests received</a></li>
                        <li><a class="dropdown-item" href="saved"> Saved</a></li>
                        <li><a class="dropdown-item" href="Property_list"> Property Listing</a></li>
                        <li><a class="dropdown-item" href="Property_all_list"> All Property Listing</a></li>
                        <li><a class="dropdown-item" href="UserProfile">Update Profile</a></li>
                        <li><a class="dropdown-item" href="chngepswd">Change Password </a></li>
                        <li><a class="dropdown-item" href="../logout">Logout</a></li>
                    </ul>
                </div>
                <?php else: ?>
                    <a href="../login">
                <nav class="login-btn">
                        Login / Sign Up
                </nav>
                        </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>



 <!-- Results Section -->
 <div id="results" class="container">
        <!-- Search results will be displayed here -->
    </div>

    <script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    function checkEnter(event) {
        if (event.key === 'Enter') {
            const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();

            switch (searchInput) {
                case 'rent':
                    window.location.href = '../index.php';
                    break;
                case 'sale':
                    window.location.href = '../home2.php';
                    break;
                case 'commercial':
                    window.location.href = '../home3.php';
                    break;
                case 'movers & packers':
                case 'movers':
                case 'packers':
                    window.location.href = '../services2.php?service=' + encodeURIComponent('Movers & Packers');
                    break;
                case 'electrician':
                case 'plumbing':
                case 'cleaning services':
                case 'interiors':
                case 'exteriors':
                    window.location.href = '../services2.php?service=' + encodeURIComponent(searchInput);
                    break;
                default:
                    window.location.href = 'property.php';
                    break;
            }
        }
    }
    </script>

</body>

</html>