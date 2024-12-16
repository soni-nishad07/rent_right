<?php
include('../connection.php');
include('session_check.php');

// Check if a delete request was made
$id = $_GET['id'];
// $con = mysqli_connect("localhost","root","","nurseray_plant");
$query = "delete from properties where id='$id'  ";
$res = mysqli_query($conn,$query);


if($res){
    echo  "<script> alert('Property successfully deleted');
    window.location.href='property_list';
    </script>";
         }
         else
         {      
            echo  "<script> alert('Property does not deleted');
            window.location.href='property_list_details';
            </script>";         
         }

?>


