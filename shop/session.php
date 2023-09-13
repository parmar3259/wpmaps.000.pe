<?php
//    session_start();
include('../database/connection.php');

   if (isset($_SESSION['email']) && isset($_SESSION['fullname'])) {
    $fullname = $_SESSION['fullname'];
    $email = $_SESSION['email'];
    $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['id'];
    }



   }
?>
