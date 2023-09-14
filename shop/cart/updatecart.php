<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../../database/connection.php');
session_start();

// Initialize a response array
$response = array();
if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    // Your code here
} else {
    // Handle the case when data is not received as expected
    echo json_encode(['success' => false, 'message' => 'Data not received as expected.']);
}


if ($quantity == 0) {
    $quantity = 1;
}

$query = "SELECT * FROM cartdata WHERE cart_id = '$cart_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Product with the same size already exists, update the quantity
    $row = mysqli_fetch_assoc($result);
    $updateQuery = "UPDATE cartdata SET product_quantity = '$quantity' WHERE cart_id = '$cart_id'";
    if (mysqli_query($conn, $updateQuery)) {
        // Set a success message in the response
        $response['success'] = true;
        $response['message'] = 'Quantity updated successfully.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error updating quantity: ' . mysqli_error($conn);
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Product not found in the cart.';
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
