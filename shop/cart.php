<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
<link rel="stylesheet" href="assets/css/owl-carousel.css">
<link rel="stylesheet" href="assets/css/cart.css">

<body>
    <?php 
    session_start();
    require('../database/connection.php');


    if (isset($_SESSION['email']) && isset($_SESSION['fullname'])) {
        $fullname = $_SESSION['fullname'];
        $email = $_SESSION['email'];
        $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['id'];
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo 'You are not allowed on this page. Please log in first.';
        echo '</div>';
       die;
    }
    
    require('./extra_file/navbar.php');

    ?>
    <section class="section">
        <div class="container pb-5 mt-n2 mt-md-n3">
            <div class="row">
                <div class="col-xl-9 col-md-8">
                    <h2 class="h6 d-flex flex-wrap justify-content-between align-items-center px-4 py-3 bg-secondary">
                        <span>Products</span><a class="font-size-sm" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left" style="width: 1rem; height: 1rem;">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>Continue shopping</a>
                    </h2>



                    <?php
                    if (isset($_SESSION['email']) && isset($_SESSION['fullname'])) {
                        $fullname = $_SESSION['fullname'];
                        $email = $_SESSION['email'];
                        $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $user_id = $row['id'];
                        }
                    }

                    function displayCartItems($conn, $user_id)
                    {
                                            // Fetch cart data for the user from cartdata table
                    $cartQuery = "SELECT cartdata.cart_id,cartdata.product_size, cartdata.product_color, cartdata.product_Quantity, products.product_image_path, products.product_name, products.product_rate, products.upload_through, products.product_id
                    FROM cartdata
                    JOIN products ON cartdata.product_id = products.product_id
                    WHERE cartdata.user_id = '$user_id'";
                          $total = 0;
      
      
                          $cartResult = mysqli_query($conn, $cartQuery);
                          if (mysqli_num_rows($cartResult) > 0) {
      
      
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
      
                              <div id="update-message" class="alert alert-success custom-message" style="display: none;"></div>
                              <div class="product-container" data-productid="<?php echo $cart_id; ?>">
      
                                  <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                      <div class="media d-block d-sm-flex text-center text-sm-left">
                                          <a class="cart-item-thumb mx-auto mr-sm-4" href="#"><img src="<?php echo $productImage;    ?>" alt="Product"></a>
                                          <div class="media-body pt-3">
                                              <h3 class="product-card-title font-weight-semibold border-0 pb-0"><a href="#"><?php echo $productName;    ?></a></h3>
                                              <div class="font-size-sm"><span class="text-muted mr-2">Size:</span><?php echo $productSize;    ?></div>
                                              <div class="font-size-sm"><span class="text-muted mr-2">Color:</span><?php echo $productcolor;    ?></div>
                                              <div class="font-size-lg text-primary pt-2"> ₹<?php echo $productrate;    ?></div>
                                          </div>
                                      </div>
      
                                      <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 10rem;">
                                          <div class="form-group mb-2">
                                              <label for="quantity1">Quantity</label>
                                              <input class="form-control form-control-sm" type="number" id="quantity<?php echo $cart_id; ?>" value="<?php echo $productQuantity; ?>">
                                          </div>
                                          <button class="btn btn-outline-secondary btn-sm btn-block mb-2 update-button" type="button">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw mr-1">
                                                  <polyline points="23 4 23 10 17 10"></polyline>
                                                  <polyline points="1 20 1 14 7 14"></polyline>
                                                  <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                              </svg>Update cart</button>
                                          <button class="btn btn-outline-danger btn-sm btn-block mb-2 remove-button" type="button">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 mr-1">
                                                  <polyline points="3 6 5 6 21 6"></polyline>
                                                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                  </path>
                                                  <line x1="10" y1="11" x2="10" y2="17"></line>
                                                  <line x1="14" y1="11" x2="14" y2="17"></line>
                                              </svg>Remove</button>
                                      </div>
      
                                  </div>
                              </div>
      
                          <?php  } ?>
      
      
                      </div>
      
                      <div class="col-xl-3 col-md-4 pt-3 pt-md-0">
                          <h2 class="h6 px-4 py-3 bg-secondary text-center">Subtotal</h2>
                          <div class="h3 font-weight-semibold text-center py-3" id="subtotal">₹</div>
                          <hr>
                          <a class="btn btn-primary btn-block" href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2">
                                  <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                  <line x1="1" y1="10" x2="23" y2="10"></line>
                              </svg>Proceed to Checkout
                          </a>
                      </div>
      
                      <?php
      
      } else {
          // Handle the case when there is no data in the result set
          echo '<div class="alert alert-warning mt-3 mb-3" role="alert">Please add products to the cart first.</div>';
      }
                    }


                    displayCartItems($conn, $user_id);


?>


            </div>
        </div>
    </section>


    <?php require('./extra_file/footer.php'); ?>

    <?php require('./extra_file/script.php'); ?>
    <script>
        $(document).ready(function() {

            function updateSubtotal() {
                $.ajax({
                    url: './cart/fetch_total.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.total) {
                            
                            // Update the subtotal element
                            $('#subtotal').text('₹' + response.total.toFixed(2));
                        }
                    },
                    error: function() {
                        console.error('Error fetching cart total');
                    }
                });
            }

            // Initial update of subtotal
            updateSubtotal();

            $('.update-button').on('click', function() {
                var productContainer = $(this).closest('.product-container');
                var cart_id = productContainer.data('productid');
                var quantity = $('#quantity' + cart_id).val();
                var requestData = {
                    cart_id: cart_id,
                    quantity: quantity
                };
                var updateMessage = $('#update-message'); // Cache the element for better performance

                $.ajax({
                    url: './cart/updatecart.php',
                    method: 'POST',
                    data: requestData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var message = response.message;
                            updateMessage.text(message).removeClass('alert-danger').addClass('alert-success custom-message').show();
                            updateSubtotal();

                        } else {
                            var errorMessage = response.message;
                            updateMessage.text(errorMessage).removeClass('alert-success').addClass('alert-danger custom-message').show();
                            console.error(errorMessage);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = "An error occurred while updating.";
                        updateMessage.text(errorMessage).removeClass('alert-success').addClass('alert-danger custom-message').show();
                        console.error(errorMessage);
                    }
                });

            });





            // Handle click on the "Remove" button
            $('.remove-button').on('click', function() {
                // Find the parent product container
                var productContainer = $(this).closest('.product-container');

                // Get the cart_id from the data attribute
                var cart_id = productContainer.data('productid');
                var updateMessage = $('#update-message'); // Cache the element for better performance
                // Send an AJAX request to deleteCartitem.php
                $.ajax({
                    type: 'POST',
                    url: './cart/deleteCartItem.php', // Update the URL to the correct path
                    data: {
                        cart_id: cart_id
                    },
                    success: function(response) {
                      
                        var message = response.message;
                        updateMessage.text(message).removeClass('alert-danger').addClass('alert-danger custom-message').show();
                        updateSubtotal();

                        productContainer.remove();

                    },
                    error: function(xhr, status, error) {
                        var errorMessage = response.message;
                        updateMessage.text(errorMessage).removeClass('alert-success').addClass('alert-danger custom-message').show();
                        console.error(errorMessage);
                    }
                });
            });

        });

        $(function() {
            var selectedClass = "";
            $("p").click(function() {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function() {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });
    </script>