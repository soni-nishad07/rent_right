<style>
    /* Responsive padding for small screens */

    @media (max-width: 1025px) {
        .copyright {
            color: #000;   
            padding: 0 25% !important; 
            font-size: 14px; 
            text-align: center;
            width: 100%; 
            display: inline-block;
        }
    }

    @media (max-width: 765px) {
        .copyright {
            color: #000;   
            padding: 0 25% !important; 
            font-size: 14px; 
            text-align: center;
            width: 100%; 
            display: inline-block;
        }
    }

    @media (max-width: 576px) {
        .copyright {
            padding: 0 15% !important; 
            font-size: 14px; 
            text-align: center;
            width: 100%; 
        }
    }
</style>



<footer>
    <div class="footer-container">
        <div class="footer-logo">
            <?php if (isset($_SESSION['user_name'])): ?>
                <img src="../icons/Logo.png" alt="Company Logo">
            <?php else: ?>
                <img src="./icons/Logo.png" alt="Company Logo">
            <?php endif; ?>
        </div>
        <div class="footer-links">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>

    </div>
</footer>




<div class="container-fluid pt-2 pb-2">
    <h6 class="text-center copyright">COPYRIGHT @ 2024 <b style=" color: #ff6f6f;">Rent Right Bangalore</b> . ALL RIGHTS RESERVED.
        <!--
         Designed by
      <span>
        <a style="text-decoration: none; color: #000; font-weight: 700;" href="https://www.rpinfocare.com/">RP
        INFOCARE</a>
    </span>
    --->
    </h6>
</div>