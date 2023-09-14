<?php
    require('../../database/connection.php');

    $response = array();

    // Get the values from the query parameters
    $cart_id = $_POST['cart_id'];

    // Delete the entry from the cartdata table
    $deleteQuery = "DELETE FROM cartdata WHERE cart_id = '$cart_id'";
    
    if (mysqli_query($conn, $deleteQuery)) {                         
        $response['success'] = true;
        $response['message'] = 'Product removed successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error removing product: ' . mysqli_error($conn);
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
?>
