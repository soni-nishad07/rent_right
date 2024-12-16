<?php
// session_start();

$conn = mysqli_connect("localhost","root","","trustpro_rentrightbangalore");

mysqli_select_db($conn,"trustpro_rentrightbangalore");

// Check connection
if (mysqli_connect_error())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>