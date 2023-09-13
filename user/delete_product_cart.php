<?php
// delete_product.php

// Establish a database connection (assuming you have already done this)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../database/connection.php');
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_POST['user_id'];
    $item_index = $_POST['item_index'];
    $invoice_id = $_POST['invoice_id'];
    $url = "view_order.php?user_id=" . urlencode($user_id) . "&invoice_id=" . urlencode($invoice_id);

   
    // Retrieve the cart_data from the database using the $user_id
    $query = "SELECT cart_data FROM orders WHERE user_id = '$user_id' AND invoice_id = '$invoice_id' ";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cart_data = unserialize($row['cart_data']);

        // Check if the item index exists in the cart_data array
        if (isset($cart_data[$item_index])) {


        $cart_data[$item_index]['delivered'] = 'Returned';

                    // print_r($cart_data[$item_index]);
            // die;
            // // Remove the item from the cart_data array
            // unset($cart_data[$item_index]);

            // Serialize the updated cart_data
            $updated_cart_data = serialize($cart_data);

            // Update the cart_data in the database
            $update_query = "UPDATE orders SET cart_data = '$updated_cart_data' WHERE user_id = '$user_id' AND invoice_id = '$invoice_id' ";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                // Redirect back to the page where the cart is displayed
                header("Location: " . $url);                
                exit();
            } else {
                echo 'Error updating cart data: ' . mysqli_error($conn);
            }
        } else {
            echo 'Invalid item index.';
        }
    } else {
        echo 'Cart data not found.';
    }
}

// Close the database connection (assuming you have already done this)
mysqli_close($conn);
?>
