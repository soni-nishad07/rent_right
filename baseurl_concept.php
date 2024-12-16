

<?php
// Determine the base URL based on the current script's directory
$base_url = (strpos($_SERVER['REQUEST_URI'], '/users/') !== false) ? '../' : '';
?>

<ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $base_url; ?>index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url; ?>about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url; ?>contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <?php if(isset($_SESSION['user_name'])): ?>
                        <a class="nav-link" href="<?= $base_url; ?>users/post-property.php">Post Free Property</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?= $base_url; ?>users/property.php">Post Property</a>
                    <?php endif; ?>
                </li>
            </ul>
