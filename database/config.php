<?php
$host = "";
$dbname = "";
$dbuser = "";
$dbpassword = "";

if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    // Local development environment
    $host = "localhost";
    $dbname = "phulkarieva";
    $dbuser = "root";
    $dbpassword = "";
} else {
    // Production or remote server environment
    $host = "sql300.infinityfree.com";
    $dbname = "if0_34644032_phulkari_eva";
    $dbuser = "if0_34644032";
    $dbpassword = "h7nD2WfXGv";
}

?>
