<?php
    include('../../database/connection.php');

    // Get the values from the query parameters
    $cart_id = $_POST['cart_id'];

    // Delete the entry from the cartdata table
    $deleteQuery = "DELETE FROM cartdata WHERE cart_id = '$cart_id'";
    if (mysqli_query($conn, $deleteQuery)) {                         
        header("Location: ../cart.php");
} else {
    echo "Error updating quantity: " . mysqli_error($conn);
}

    

?>
