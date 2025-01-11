<!-- footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-logo">
                      <?php
                // Set image path based on URL structure
                $imagePath = (strpos($_SERVER['REQUEST_URI'], 'users/') !== false) ? './Logo.png' : 'img/Logo.png';
            ?>
            <img src="<?php echo $imagePath; ?>" alt="Rent Right">
            <p> No.138, 20th Main Road,
            7th Cross, <br> BTM 2nd Stage, 
                            Bangalore, 560076.
                        </p>
                        <div class="calling">
                <a href="tel:+919538865407">
                            <i class="fas fa-phone"></i> +91-9538865407
                        </a>
            </div>
            <!-- <div class="social-icons">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div> -->
        </div>

        <!-- Quick Links -->
        <div class="quick-links">
            <h3>Quick Links</h3>
            <!-- <ul>
                <?php
                    $homeLink = (strpos($_SERVER['REQUEST_URI'], 'users/') !== false) ? '../index' : 'index';
                ?>
                <li><a href="<?php echo $homeLink; ?>">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul> -->
            <ul>
                <?php
                    // Set link paths based on URL structure
                    $homeLink = (strpos($_SERVER['REQUEST_URI'], 'users/') !== false) ? '../index' : 'index';
                    $aboutLink = (strpos($_SERVER['REQUEST_URI'], 'users/') !== false) ? '../about' : 'about';
                    $contactLink = (strpos($_SERVER['REQUEST_URI'], 'users/') !== false) ? '../contact' : 'contact';
                    // $privacyLink = (strpos($_SERVER['REQUEST_URI'], 'users/') !== false) ? '../privacy' : 'privacy';
                ?>
                <li><a href="<?php echo $homeLink; ?>">Home</a></li>
                <li><a href="<?php echo $aboutLink; ?>">About Us</a></li>
                <li><a href="<?php echo $contactLink; ?>">Contact Us</a></li>
                <!-- <li><a href="<?php echo $privacyLink; ?>">Privacy Policy</a></li> -->
            </ul>
        </div>
    </div>
</footer>

<div class="container-fluid pt-2 pb-2 footer_copyright">
    <h6 class="text-center" style="display: inline-block; text-align: center; padding: 0px 25%;">COPYRIGHT @ 2024 <b>Rent Right Bangalore</b> . ALL RIGHTS RESERVED.
    </h6>
</div>
