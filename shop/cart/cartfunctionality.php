<?php
include('../../database/connection.php');
session_start();

if(isset($_SESSION['email']) && isset($_SESSION['fullname'])) {
    if (isset($_POST['addtocart'])) {
        if ($_POST['addtocart'] === 'addtocart') {
                    
            $fullname = $_SESSION['fullname'];
            $email = $_SESSION['email'];
            // echo "Welcome, $fullname. Your email is $email.";

            $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['id'];
            }

            if (isset($_POST['product_id'], $_POST['product_size'], $_POST['quantity'])) {
                // Variables are set
                $product_id = $_POST['product_id'];
                $product_size = $_POST['product_size'];
                $product_color = $_POST['product_color'];

                $quantity = $_POST['quantity'];
            
                // Further processing or validation
            } else {
                echo " not set";
            }
            // Check if the same product with the same size already exists in the cart
            $query = "SELECT * FROM cartdata WHERE user_id = '$user_id' AND product_id = '$product_id' AND product_size = '$product_size'AND product_color = '$product_color' ";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Product with the same size already exists, update the quantity
                $row = mysqli_fetch_assoc($result);
                $existingQuantity = $row['product_quantity'];
                $newQuantity = $existingQuantity + $quantity;

                $updateQuery = "UPDATE cartdata SET product_quantity = '$newQuantity' WHERE user_id = '$user_id' AND product_id = '$product_id' AND product_size = '$product_size'AND product_color = '$product_color'";
                if (mysqli_query($conn, $updateQuery)) {
                    if (isset($product_id)) {
                          
                        header("Location: ../single-product.php?id=" . $product_id);
                    }
                } else {
                    echo "Error updating quantity: " . mysqli_error($conn);
                }
            } else {
                // Product with the same size doesn't exist, create a new entry
                
                $insertQuery = "INSERT INTO cartdata (user_id, product_id, product_size, product_color , product_quantity) 
                                VALUES ('$user_id', '$product_id', '$product_size', '$product_color', '$quantity')";
                if (mysqli_query($conn, $insertQuery)) {
                    if (isset($product_id)) {
                          
                        header("Location: ../single-product.php?id=" . $product_id);
                    }
                } else {
                    echo "Error inserting data: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>
