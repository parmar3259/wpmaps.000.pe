<?php
   include 'config.php';
// Create connection
$conn = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
// Check connection

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
//    

?>