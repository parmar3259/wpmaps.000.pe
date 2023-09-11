<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
include('../../database/connection.php');
session_start();
// Retrieve the submitted form data
$cart_id = $_POST['cart_id'];

$quantity = $_POST['quantity'];
if( $quantity == 0){
    $quantity = 1;
}

$query = "SELECT * FROM cartdata WHERE cart_id = '$cart_id'";
$result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Product with the same size already exists, update the quantity
                $row = mysqli_fetch_assoc($result);
                $updateQuery = "UPDATE cartdata SET product_quantity = '$quantity' WHERE cart_id = '$cart_id'";
                if (mysqli_query($conn, $updateQuery)) {                         
                        header("Location: ../cart.php");
                } else {
                    echo "Error updating quantity: " . mysqli_error($conn);
                }

            }
?>
