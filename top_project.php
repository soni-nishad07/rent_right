
    
    <!------------ spotlight----- -->

    <?php
    $spotlightQuery = "SELECT * FROM properties WHERE property_status = 'Spotlight' LIMIT 1";
    $result = mysqli_query($conn, $spotlightQuery);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $images = explode(',', $row['file_upload']);
    ?>
    <section class="spotlight-section">
        <div class="spotlight-header">
            <h2>In <span class="highlight">Spotlight</span></h2>
            <p>Find your best place to live with us.</p>
        </div>

    <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
        <div class="spotlight-content">
            <div class="project-info">
                <h3><?php echo htmlspecialchars($row['property_type']); ?></h3>
                <h4><?php echo htmlspecialchars($row['build_up_area']); ?> sqft</h4>
                <p><?php echo htmlspecialchars($row['city']); ?></p>
                <!-- <?php
                $expected_rent = (float)$row[''];
                $expected_deposit = (float)$row['expected_deposit'];
                $total = $expected_rent + $expected_deposit;
                ?> -->
                <!-- <p class="price-range">₹<?php echo number_format($total, 2); ?></p> -->
                <p class="price-range">₹<?php echo htmlspecialchars($row['expected_rent']);?></p>
                <p class="bhk-info"><?php echo htmlspecialchars($row['bhk_type']); ?></p>
                <a href="users/property.php" class="contact-btn">View Projects  </a>
              
            </div>
            <div class="project-image">
                <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                    alt="<?php echo htmlspecialchars($row['property_type']); ?>">
            </div>
        </div>
           </a>
        <div class="thumbnail-carousel">
            <?php foreach ($images as $image) { ?>
            <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Thumbnail">
            <?php } ?>
        </div>
    </section>
 
    <?php
}
?>






    <!-- ------Focus projects------- -->
    <?php
$focusQuery = "SELECT * FROM properties WHERE property_status = 'Focus' LIMIT 2"; // Adjust LIMIT as needed
$result = mysqli_query($conn, $focusQuery);

// Check if there are any results
if ($result && mysqli_num_rows($result) > 0) {
?>
    <section class="focus_section">
        <div class="container">
            <div class="spotlight-header">
                <h2>Projects in <span class="focus_heading">Focus</span></h2>
                <p>Find your best place to live with us.</p>
            </div>

            <div class="focus_project">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $images = explode(',', $row['file_upload']);
                    $user_id = $row['user_id']; // Adjust this field name as necessary
                    $userQuery = "SELECT * FROM customer_register WHERE id = '$user_id'";
                    $userResult = mysqli_query($conn, $userQuery);

                    if ($userResult && mysqli_num_rows($userResult) > 0) {
                        $userData = mysqli_fetch_assoc($userResult);
                        $userName = htmlspecialchars($userData['name']);
                    } else {
                        $userName = 'Unknown';
                    }
                    // $expected_rent = (float)$row['expected_rent'];
                    // $expected_deposit = (float)$row['expected_deposit'];
                    // $total = $expected_rent + $expected_deposit;
                ?>
                
                    <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                <div class="card-top">
                    <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                        alt="<?php echo htmlspecialchars($row['property_type']); ?>">
                    <div class="card-top-content">
                        <h2><?php echo htmlspecialchars($row['property_type']); ?></h2>
                        <!-- <h3>by <?php echo $userName; ?></h3> -->
                        <p><?php echo htmlspecialchars($row['bhk_type']); ?>
                            Apartments<br><?php echo htmlspecialchars($row['city']); ?></p>
                        <p class="price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                    </div>
                </div>
                </a>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
} else {
    echo '<!-- No Focus properties available at the moment. -->';
}
?>





<!-- Rental img -->


<?php
// Query to fetch trending properties
$trendingQuery = "SELECT * FROM properties  ORDER BY id DESC "; // Adjust query as needed
$trendingResult = mysqli_query($conn, $trendingQuery);
if ($trendingResult && mysqli_num_rows($trendingResult) > 0) {
    $count = 0; // Initialize a counter
?>
<section class="trending">
    <div class="container">
        <h2 class="title-trending">Rental Project in <span>Bengaluru</span></h2>
        <p class="subtitle-trending">All Projects in Bengaluru</p>
        <div class="grid">
            <?php
            while ($row = mysqli_fetch_assoc($trendingResult)) {
                if ($count >= 4) break; // Display only the first 4 cards
                
                $images = explode(',', $row['file_upload']);
                $user_id = $row['user_id']; // Adjust this field name as necessary
                $userQuery = "SELECT * FROM customer_register WHERE id = '$user_id'";
                $userResult = mysqli_query($conn, $userQuery);
                
                if ($userResult && mysqli_num_rows($userResult) > 0) {
                    $userData = mysqli_fetch_assoc($userResult);
                } else {
                    $userName = 'Unknown';
                }
            ?>
            <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                <div class="card-project">
                    <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                         alt="<?php echo htmlspecialchars($row['property_type']); ?>" class="card-project-img">
                    <div class="card-project-content">
                        <h3 class="card-project-title-trending"><?php echo htmlspecialchars($row['property_type']); ?></h3>
                        <!-- <p class="card-project-company">by <?php echo $userName; ?></p> -->
                        <p class="card-project-description"><?php echo htmlspecialchars($row['bhk_type']); ?>
                            Apartments<br><?php echo htmlspecialchars($row['city']); ?></p>
                        <p class="card-project-price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                    </div>
                </div>
            </a>
            <?php
            $count++; // Increment counter
            }
            ?>
        </div>
        
        <!-- Show the "View More" button if there are more than 4 properties -->
        <?php if (mysqli_num_rows($trendingResult) > 4): ?>
            <div class="view-more-container" style="text-align:center; margin-top: 20px;color:white;">
                <a href="users/property.php" class="view-more-btn">View More</a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
} else {
    echo  '<!-- <p style="text-align:center;">No Rental properties available at the moment.</p>  -->';
}
?>







    <!-- -------------Trending projects----- -->

    <?php
      // Query to fetch trending properties
      $trendingQuery = "SELECT * FROM properties WHERE property_status = 'Trending' LIMIT 6"; // Adjust LIMIT as needed
      $trendingResult = mysqli_query($conn, $trendingQuery);
      if ($trendingResult && mysqli_num_rows($trendingResult) > 0) {

  ?>
    <section class="trending">
        <div class="container">
            <h2 class="title-trending">Trending <span>Projects</span></h2>
            <p class="subtitle-trending">Most sought-after projects in Lucknow</p>
            <div class="grid">
                <?php
              while ($row = mysqli_fetch_assoc($trendingResult)) {

                  $images = explode(',', $row['file_upload']);
                  $user_id = $row['user_id']; // Adjust this field name as necessary
                  $userQuery = "SELECT * FROM customer_register WHERE id = '$user_id'";
                  $userResult = mysqli_query($conn, $userQuery);
                    
                    if ($userResult && mysqli_num_rows($userResult) > 0) {
                        $userData = mysqli_fetch_assoc($userResult);
                    } else {
                        $userName = 'Unknown';
                    }

            ?>
            
                <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                <div class="card-project">
                    <img src="uploads/<?php echo htmlspecialchars($images[0]); ?>"
                        alt="<?php echo htmlspecialchars($row['property_type']); ?>" class="card-project-img">
                    <div class="card-project-content">
                        <h3 class="card-project-title-trending"><?php echo htmlspecialchars($row['property_type']); ?>
                        </h3>
                        <!-- <p class="card-project-company">by <?php echo $userName; ?></p> -->
                        <p class="card-project-description"><?php echo htmlspecialchars($row['bhk_type']); ?>
                            Apartments<br><?php echo htmlspecialchars($row['city']); ?></p>
                        <p class="card-project-price">₹<?php echo htmlspecialchars($row['expected_rent']); ?></p>
                    </div>
                </div>
                </a>
                <?php
                }
            } else {
                echo  '<!-- <p style="text-align:center;">No Trending properties available at the moment.</p>  -->';
            }
            ?>
            </div>
        </div>
    </section>





    <!------------------- Featured----------- -->


<?php
// Query to fetch 'Featured' properties
$featuredQuery = "SELECT * FROM properties WHERE property_status = 'Featured' LIMIT 6"; // Adjust LIMIT as needed
$result = mysqli_query($conn, $featuredQuery);
$hasProperties = false; // Flag to check if there are properties

if ($result && mysqli_num_rows($result) > 0) {
    $hasProperties = true; // Set flag to true if there are properties
?>

<section class="featured-collections">
    <div class="container">
        <h2 class="section-title">Featured <span>Projects</span></h2>
        <p class="section-subtitle">Handpicked projects for you</p>
        <div class="slider-wrapper">
            <div class="collections-grid">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $images = explode(',', $row['file_upload']);
                    $imageSrc = htmlspecialchars($images[0]);
                    $title = htmlspecialchars($row['property_type']);
                    $description = htmlspecialchars($row['description']);
                ?>
                    <a href="users/property-results.php?id=<?php echo (int)$row['id']; ?>" class="card-link">
                <div class="collection-card">
                    <img src="uploads/<?php echo $imageSrc; ?>" alt="<?php echo $title; ?>">
                    <div class="overlay2">
                        <h3><?php echo $title; ?></h3>
                        <p><?php echo $description; ?></p>
                    </div>
                </div>
                </a>
                <?php
                }
                ?>
            </div>
        </div>

        <?php if ($hasProperties) { // Show arrows only if there are properties ?>
        <div class="arrows">
            <button class="arrow-btn left">&#10094;</button>
            <button class="arrow-btn right">&#10095;</button>
        </div>
        <?php } // End of arrows display condition ?>
    </div>
</section>

<?php
}
?>


