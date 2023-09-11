<!DOCTYPE html>
<html lang="en">

<head>
    <title>phulkari eva - Contact</title>
    <?php
    include('./cssfiles.php');
    ?>

    <style type="text/css">
        .cart-item-thumb {
            display: block;
            width: 10rem
        }

        .cart-item-thumb>img {
            display: block;
            width: 100%
        }

        .product-card-title>a {
            color: #222;
        }

        .font-weight-semibold {
            font-weight: 600 !important;
        }

        .product-card-title {
            display: block;
            margin-bottom: .75rem;
            padding-bottom: .875rem;
            border-bottom: 1px dashed #e2e2e2;
            font-size: 1rem;
            font-weight: normal;
        }

        .text-muted {
            color: #888 !important;
        }

        .bg-secondary {
            background-color: #f7f7f7 !important;
        }

        .accordion .accordion-heading {
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: bold;
        }

        .font-weight-semibold {
            font-weight: 600 !important;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php
    include('./navbar.php');
    ?>
    <div class="container py-5">
        <div class="row py-5">
            <div class="container pb-5 mt-n2 mt-md-n3">
                <div class="row">
                    <div class="col-xl-9 col-md-8">
                        <h2 class="h6 d-flex flex-wrap justify-content-between align-items-center px-4 py-3 bg-secondary">
                            <span>Products</span><a class="font-size-sm" href="./shop.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left" style="width: 1rem; height: 1rem">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>Continue shopping</a>
                        </h2>


                        <?php
                        include('../database/connection.php');
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
                        $cartQuery = "SELECT cartdata.cart_id,cartdata.product_size, cartdata.product_color, cartdata.product_Quantity, products.product_image_path, products.product_name, products.product_rate, products.upload_through, products.product_id
              FROM cartdata
              JOIN products ON cartdata.product_id = products.product_id
              WHERE cartdata.user_id = '$user_id'";
                        $total = 0;


                        $cartResult = mysqli_query($conn, $cartQuery);
                        while ($cartRow = mysqli_fetch_assoc($cartResult)) {

                            $cart_id = $cartRow['cart_id'];
                            $productid = $cartRow['product_id'];
                            $productSize = $cartRow['product_size'];
                            $productQuantity = $cartRow['product_Quantity'];
                            $productImage = $cartRow['product_image_path'];
                            $productName = $cartRow['product_name'];
                            $productcolor = $cartRow['product_color'];
                            $productrate = $cartRow['product_rate'];

                            if ($cartRow['upload_through'] == 'json') {
                                // Extract the file ID using regular expressions
                                $pattern = '/\/d\/(.*?)\//';
                                preg_match($pattern, $productImage, $matches);
                                if (isset($matches[1])) {
                                    $fileId = $matches[1];
                                    $productImage = 'https://drive.google.com/uc?id=' . $fileId;
                                }
                            } else {
                                $productImage = ltrim($productImage, '.');
                                $prefix = "../admin";
                                $productImage = $prefix . $productImage;
                            }


                            // Calculate the subtotal for each item
                            $subtotal = $productrate * $productQuantity;
                            $total += $subtotal; // Add subtotal to the total



                        ?>
                            <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                <div class="media d-block d-sm-flex text-center text-sm-left">
                                    <a class="cart-item-thumb mx-auto mr-sm-4" href="#"><img src="<?php echo $productImage;    ?>" alt="Product" /></a>
                                    <div class="media-body pt-3">
                                        <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                            <a href="#"><?php echo $productName;    ?></a>
                                        </h3>
                                        <div class="font-size-sm">
                                            <span class="text-muted mr-2">Size:</span><?php echo $productSize;    ?>
                                        </div>
                                        <div class="font-size-sm">
                                            <span class="text-muted mr-2">Color:</span><?php echo $productcolor;    ?>
                                        </div>
                                        <div class="font-size-lg text-primary pt-2">$<?php echo $productrate;    ?></div>
                                    </div>
                                </div>
                                <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 10rem">


                                    <form action="./cart/updatecart.php" method="POST">
                                        <input type="hidden" name="cart_id" value="<?php echo htmlentities($cart_id); ?>">
                                        <!--  -->

                                        <div class="form-group mb-2">
                                            <label for="quantity<?php echo $productid; ?>">Quantity</label>
                                            <input class="form-control form-control-sm" type="number" id="quantity<?php echo $productid; ?>" name="quantity" value="<?php echo $productQuantity; ?>" />
                                        </div>
                                        <button class="btn btn-outline-secondary btn-sm btn-block mb-2" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw mr-1">
                                                <polyline points="23 4 23 10 17 10"></polyline>
                                                <polyline points="1 20 1 14 7 14"></polyline>
                                                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                            </svg>Update cart
                                        </button>
                                    </form>
                                    <form action="./cart/deletecartitem.php" method="POST">
                                        <input type="hidden" name="cart_id" value="<?php echo htmlentities($cart_id); ?>">

                                        <button class="btn btn-outline-danger btn-sm btn-block mb-2" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 mr-1">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php  } ?>

                    </div>

                    <!-- Code for displaying the subtotal -->
                    <div class="col-xl-3 col-md-4 pt-3 pt-md-0">
                        <h2 class="h6 px-4 py-3 bg-secondary text-center">Subtotal</h2>
                        <div class="h3 font-weight-semibold text-center py-3">$<?php echo number_format($total, 2); ?></div>
                        <hr />
                        <!-- <h3 class="h6 pt-4 font-weight-semibold">
                            <span class="badge badge-success mr-2">Note</span>Additional comments
                        </h3> -->
                        <!-- <textarea class="form-control mb-3" id="order-comments" rows="5"></textarea> -->
                        <a class="btn btn-primary btn-block" href="./proceedToCheckOut.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->

    <?php
    include('./footer.php');
    ?>
    <!-- <script>
        function removeFromCart(user_id, productid, productSize) {
            // Make an AJAX request to cartdelete.php with the parameters
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Handle the response from deleteCartItem.php if needed
                    console.log(this.responseText);


                }
            };
            xhttp.open("GET", "./cart/deleteCartItem.php?user_id=" + user_id + "&product_id=" + productid + "&sproduct_size=" + productSize, true);
            xhttp.send();
        }
    </script> -->

    <!-- JavaScript code for updating the cart -->
    <script>
        // Add event listeners to update cart buttons
        // var updateButtons = document.getElementsByClassName('update-cart');
        // Array.prototype.forEach.call(updateButtons, function(button) {
        //     button.addEventListener('click', function() {
        //         var userId = button.getAttribute('data-user-id');
        //         var productId = button.getAttribute('data-product-id');
        //         var quantityInput = document.getElementById('quantity' + productId);
        //         var newQuantity = quantityInput.value;

        //         // Perform the update operation using AJAX or form submission
        //         // Here, I'll provide an example using jQuery AJAX
        //         $.ajax({
        //             url: 'update_cart.php', // Replace with the actual update script URL
        //             method: 'POST',
        //             data: {
        //                 user_id: userId,
        //                 product_id: productId,
        //                 quantity: newQuantity
        //             },
        //             success: function(response) {
        //                 // Handle the success response, if needed
        //                 // You can update the cart display dynamically or refresh the page
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle the error, if needed
        //             }
        //         });
        //     });
        // });
    </script>
</body>

</html>