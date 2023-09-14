<?php
    require('../../database/connection.php');
    session_start();

    if (isset($_SESSION['email']) && isset($_SESSION['fullname'])) {
                        $fullname = $_SESSION['fullname'];
                        $email = $_SESSION['email'];
                        $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $user_id = $row['id'];
                        }
                    }
                    // Fetch cart data for the user from cartdata table
                    $cartQuery = "SELECT cartdata.product_Quantity, products.product_rate,products.product_id
              FROM cartdata
              JOIN products ON cartdata.product_id = products.product_id
              WHERE cartdata.user_id = '$user_id'";
                    $total = 0;


                    $cartResult = mysqli_query($conn, $cartQuery);

                    while ($cartRow = mysqli_fetch_assoc($cartResult)) {

                
                        $productQuantity = $cartRow['product_Quantity'];
                     

                        $productrate = $cartRow['product_rate'];

                        // Calculate the subtotal for each item
                        $subtotal = $productrate * $productQuantity;
                        $total += $subtotal; // Add subtotal to the total

                    }

// Return the total as JSON
echo json_encode(['total' => $total]);
?>
