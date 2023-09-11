<?php
   include 'config.php';
// Create connection
$conn = mysqli_connect($host,$dbuser,$dbpassword,$dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// print_r("connection done");

?>