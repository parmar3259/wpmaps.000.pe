<!DOCTYPE html>
<html lang="en">

<head>
    <title>phulkari eva - Contact</title>
    <?php
    include('./cssfiles.php');
    include('./session.php');

    ?>
    <style type="text/css">
        /* .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .text-reset {
            --bs-text-opacity: 1;
            color: inherit !important;
        } */

        /* a {
            color: #5465ff;
            text-decoration: none;
        } */
    </style>
</head>

<body>



    <!-- Header -->
    <?php
    include('./navbar.php');
    include('../database/connection.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    ?>
    <!-- Close Header -->

    <div class="container-fluid">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center py-3">
                <?php $invoiceNumber =  rand(10000,   99999); ?>
                <h2 class="h5 mb-0"><a href="#" class="text-muted"></a>Order # <?php echo $invoiceNumber; ?></h2>
            </div>

            <div class="row">
                <div class="col-lg-8">

                    <div class="card mb-4">
                        <div class="card-body">

                            <table class="table table-borderless">
                                <tbody>


                                    <?php

                              

                                    $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $user_id = $row['id'];
                                       
                                    }
                                    // }


                                    $cart_data = []; // Create an empty array



                                    $cartQuery = "SELECT cartdata.cart_id,cartdata.product_size, cartdata.product_color, cartdata.product_Quantity, products.product_image_path, products.product_name, products.product_rate, products.product_id
                                    FROM cartdata
                                    JOIN products ON cartdata.product_id = products.product_id
                                    WHERE cartdata.user_id = '$user_id'";
                                    $cartResult = mysqli_query($conn, $cartQuery);
                                    while ($cartRow = mysqli_fetch_assoc($cartResult)) {

                                        $productid = $cartRow['product_id'];
                                        $productSize = $cartRow['product_size'];
                                        $productQuantity = $cartRow['product_Quantity'];
                                        $productImage = $cartRow['product_image_path'];
                                        $productName = $cartRow['product_name'];
                                        $productcolor = $cartRow['product_color'];
                                        $productrate = $cartRow['product_rate'];
                                        $productImage = ltrim($productImage, '.');
                                        $prefix = "../admin";
                                        $productImage = $prefix . $productImage;


                                        // Create an associative array for the current cart item
                                        $cart_item = [
                                            'product_id' => $productid,
                                            'product_size' => $productSize,
                                            'product_Quantity' => $productQuantity,
                                            'product_image_path' => $productImage,
                                            'product_name' => $productName,
                                            'product_color' => $productcolor,
                                            'product_rate' => $productrate,
                                            'product_total' => $productQuantity * $productrate,
                                            'delivered' => 'Not Delivered'

                                        ];

                                        // Add the cart item to the cart_data array
                                        $cart_data[] = $cart_item;

                                    ?>


                                        <tr>
                                            <td>
                                                <div class="d-flex mb-2">
                                                    <div class="flex-shrink-0">
                                                        <img src="<?php echo $productImage;    ?>" alt width="35" class="img-fluid">
                                                    </div>
                                                    <div class="flex-lg-grow-1 ms-3">
                                                        <h6 class="small mb-0"><a href="#" class="text-reset"><?php echo $productName;    ?></a></h6>
                                                        <span class="small">Color: <?php echo $productcolor;    ?></span>
                                                        <span class="small">Size: <?php echo $productSize;    ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $productQuantity; ?></td>
                                            <td class="text-end">₹<?php echo number_format($productrate, 2); ?></td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </tbody>

                                <?php
                                $total = 0; // Initialize the total variable outside the loop
                                $cartQuery = "SELECT cartdata.product_size, cartdata.product_Quantity, products.product_image_path, products.product_name, products.product_color, products.product_rate, products.product_id
                                FROM cartdata
                                JOIN products ON cartdata.product_id = products.product_id
                                WHERE cartdata.user_id = '$user_id'";
                                $cartResult = mysqli_query($conn, $cartQuery);

                                while ($cartRow = mysqli_fetch_assoc($cartResult)) {
                                    $productRate = $cartRow['product_rate'];
                                    $productQuantity = $cartRow['product_Quantity'];
                                    $subtotal = $productRate * $productQuantity;
                                    $total += $subtotal;
                                }

                                ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Subtotal</td>
                                        <td class="text-end">₹<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Shipping</td>
                                        <td class="text-end">₹20.00</td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="2">Discount (Code: NEWYEAR)</td>
                                        <td class="text-danger text-end">-$10.00</td>
                                    </tr> -->
                                    <tr class="fw-bold">
                                        <td colspan="2">TOTAL</td>
                                        <td class="text-end">₹<?php $total = $total + 20;
                                                                echo number_format($total, 2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6">Payment Method</h3>
                                    <p>COD (cash on delivery) <br>
                                        Total: ₹<?php echo number_format($total, 2); ?> <span class="badge bg-danger rounded-pill">NOT PAID</span></p>
                                </div>

                                <?php

                                if (isset($user_id)) {


                                    $query = "SELECT * FROM login WHERE id = '$user_id' AND fullname = '$fullname' AND email = '$email'";


                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    $phone_number = $row['phone_number'];
                                    $user_address = $row['user_address'];
                                    $user_address2 = $row['user_address2'];
                                    $user_city = $row['user_city'];
                                    $city_zipcode = $row['city_zipcode'];
                                    $combined_address = $user_address . "\n" . $user_address2 . " " . $user_city . ", " . $city_zipcode;


                                }




                                ?>

                                <div class="col-lg-6">
                                    <h3 class="h6">Billing address</h3>
                                    <address>
                                        <strong><?php echo $fullname; ?></strong><br>
                                        <?php echo $user_address; ?><br>
                                        <?php echo $user_address2; ?><br>

                                        <abbr title="Phone">P:</abbr><?php echo $phone_number; ?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                    <!-- <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="h6">Customer Notes</h3>
                            <p>Sed enim, faucibus litora velit vestibulum habitasse. Cras lobortis cum sem aliquet mauris rutrum. Sollicitudin. Morbi, sem tellus vestibulum porttitor.</p>
                        </div>
                    </div> -->
                    <div class="card mb-4">

                        <div class="card-body">
                            <h3 class="h6">Shipping Information</h3>
                            <!-- <strong>FedEx</strong>
                            <span><a href="#" class="text-decoration-underline" target="_blank">FF1234567890</a> <i class="bi bi-box-arrow-up-right"></i> </span> -->
                            <hr>
                            <h3 class="h6">Address</h3>
                            <address>
                                <strong><?php echo $fullname; ?></strong><br>
                                <?php echo $user_address; ?><br>

                                <?php if (isset($user_address2)) {
                                    echo $user_address2 . '<br>';
                                } ?>

                                <abbr title="Phone">P:</abbr><?php echo $phone_number; ?>
                            </address>
                        </div>
                      

                        <?php 
                        $total-=20;
                        if (
                            isset($user_id) &&    isset($email) &&    isset($fullname) &&
                            isset($combined_address) &&    isset($cart_data) &&    isset($invoiceNumber) &&  ($total > 0)
                        ) {  ?>

                        <form action="./thanks.php" method="post">
                           <input type="hidden" name="user_id" value="<?php echo htmlentities($user_id); ?>">
                            <input type="hidden" name="user_email" value="<?php echo htmlentities($email); ?>">  
                            <input type="hidden" name="user_name" value="<?php echo htmlentities($fullname); ?>">       
                            <input type="hidden" name="combined_address" value="<?php echo htmlentities($combined_address); ?>">                            
                            <input type="hidden" name="cart_data" value="<?php echo htmlentities(serialize($cart_data)); ?>">
                            <input type="hidden" name="invoiceNumber" value="<?php echo htmlentities($invoiceNumber); ?>">
                            
                            


                            <button class="btn btn-primary btn-block" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Proceed to Checkout
                            </button>
                        </form>


<?php  }else {
    $msg = '<div class="alert alert-info" role="alert">
    cart is empty
  </div>';
    print_r($msg);
}  ?>


                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php
    include('./footer.php');

    ?>
</body>

</html>