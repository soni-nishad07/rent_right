
    <!-- -------------Trending projects----- -->

    <!-- <?php
    $trendingQuery = "SELECT * FROM properties WHERE property_status = 'Trending'    AND approval_status = 'Approved'  LIMIT 6"; 
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
                        $user_id = $row['user_id']; 
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
        </section> -->