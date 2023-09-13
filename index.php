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

// Create the database connection   
$conn = mysqli_connect($host, $dbuser, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to count rows in the "products" table
$sql = "SELECT COUNT(*) AS count FROM products";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $rowCount = $row['count'];
    
    if ($rowCount > 0) {
        // The "products" table has data, redirect to user/index.php
        header('Location: ./user/index.php');
    } else {
        // The "products" table is empty, redirect to closed.php
        header('Location: ./closed.php');
    }
} else {
    die("Error counting rows: " . mysqli_error($conn));
}
?>
