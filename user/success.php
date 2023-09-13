<?php
session_start();

    if(isset($_SESSION['email'])) {
        // $fullname = $_SESSION['fullname'];
        $email = $_SESSION['email'];
        echo "Welcome, Your email is $email.";
    } else {
        echo "Session not found. Please log in.";
    }
?>
