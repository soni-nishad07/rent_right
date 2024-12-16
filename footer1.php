<!-- -------------------- -->
<section class="footer" id="footer">
    <div class="container-fluid mt-3">
        <div class="row d-flex justify-content-center pt-4">

            <?php
                        $query_bhk = "SELECT * FROM bhk_searches";
            $res_bhk = mysqli_query($conn, $query_bhk);
            if (mysqli_num_rows($res_bhk) > 0) {
            ?>
            <div class="col-md-5 mx-1 footer_section">
                <h1><b>Popular BHK Searches</b></h1>
                <hr class="footer_link" />
                <div class="buy-footer">
                    <?php while ($row_bhk = mysqli_fetch_assoc($res_bhk)) { ?>
                    <a href="users/property.php"
                        class="footer-service"><?php echo htmlspecialchars($row_bhk['name']); ?></a>
                    <?php } ?>
                </div>
            </div>
            <?php
            } else {
                echo '<div class="col-md-5 mx-1 footer_section"><h1><b>Popular BHK Searches</b></h1><hr class="footer_link" /><p>No BHK searches available.</p></div>';
            }
            
            // Dynamic Other Services
            $query_services = "SELECT * FROM services"; // Adjust the query if you have a different table for services
            $res_services = mysqli_query($conn, $query_services);
            if (mysqli_num_rows($res_services) > 0) {
            ?>
            <div class="col-md-6 footer_section">
                <h1><b>Other Services</b></h1>
                <hr class="footer_link" />
                <div class="buy-footer">
                    <?php while ($row_service = mysqli_fetch_assoc($res_services)) { ?>
                    <a href="services2.php?service=<?php echo urlencode($row_service['service_name']); ?>"
                        class="footer-service">
                        <?php echo htmlspecialchars($row_service['service_name']); ?>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <?php
            } else {
                echo '<div class="col-md-6 footer_section"><h1><b>Other Services</b></h1><hr class="footer_link" /><p>No services available.</p></div>';
            }

            mysqli_close($conn);
            ?>

        </div>
    </div>
</section>





<?php include('copyright.php'); ?>