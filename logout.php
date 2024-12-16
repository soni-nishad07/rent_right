<?php
include('connection.php');
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
echo "<script>alert('Logout successfully');
window.location.href ='index';
</script>";

exit();
?>
