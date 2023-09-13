<!DOCTYPE html>
<html lang="en">

<head>
    <title>phulkari eva - Contact</title>
    <?php
    include('./cssfiles.php');
    include('./session.php');


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
    <!-- Close Header -->
    <div class="container py-5">
        <div class="row py-5">
            <div class="container pb-5 mt-n2 mt-md-n3">
                <div class="row">
                    <div class="col-xl-12 col-md-12 border">

                        <?php
    include('../database/connection.php');


                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);

                        $filter = "Not Delivered";
                        $invoice_id = 0;
                        $user_id = 0;
                        $total = 0;
                        // if (isset($_GET['id']) && isset($_GET['user_id']) && isset($_GET['invoice_id']) ) {


                        // }


                        if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['user_id']) && isset($_GET['invoice_id'])) || isset($_GET['id'])) {
                         
                         
                            if (isset($_POST['user_id']) && isset($_POST['invoice_id'])) {
                                $user_id = $_POST['user_id'];
                                $invoice_id = $_POST['invoice_id'];

                                // Further processing for POST request
                            }
                            if(isset($_GET['id'])){
                                $filter = $_GET['id'];
                            }
                            if (isset($_GET['user_id']) && isset($_GET['invoice_id'])) {
                               
                                $user_id = $_GET['user_id'];
                                $invoice_id = $_GET['invoice_id'];

                                // Further processing for GET request
                            }




                        ?>

                            <h2 class="h6 d-flex flex-wrap justify-content-between align-items-center px-4 py-3 bg-secondary">

                                <span>Orders Not Delivered</span>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select an option
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="./view_order.php?id=<?php $filter1 = "Not Delivered";
                                                                                            echo $filter1; ?>&user_id=<?php echo $user_id; ?>&invoice_id=<?php echo $invoice_id; ?>">Not Delivered</a>
                                        <a class="dropdown-item" href="./view_order.php?id=<?php $filter1 = "Delivered";
                                                                                            echo $filter1; ?>&user_id=<?php echo $user_id; ?>&invoice_id=<?php echo $invoice_id; ?>">Delivered</a>
                                        <a class="dropdown-item" href="./view_order.php?id=<?php $filter1 = "Returned";
                                                                                            echo $filter1; ?>&user_id=<?php echo $user_id; ?>&invoice_id=<?php echo $invoice_id; ?>">Returned</a>
                                    </div>
                                </div>

                                <a class="font-size-sm" href="./orders.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left" style="width: 1rem; height: 1rem">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>Back To Orders</a>
                            </h2>



                            <?php


                            $sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND user_email = '$email'AND invoice_id = '$invoice_id'";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {


                                while ($row = mysqli_fetch_assoc($result)) {

                                    $cart_data = unserialize($row['cart_data']);


                                    // echo "<pre>";
                                    // print_r($cart_data);
                                    // die;


                                    foreach ($cart_data as $item) {


                                        if ($item['delivered'] === 'Not Delivered') {
                                            $quantity = $item['product_Quantity'];
                                            $rate = $item['product_rate'];
                                            $subtotal = $quantity * $rate;
                                            $total += $subtotal;
                                        }
                                    }


                                    // Iterate through each item in the cart_data array
                                    foreach ($cart_data as $key => $item) {
                                        $img = $item['product_image_path'];
                                        $name = $item['product_name'];
                                        $color = $item['product_color'];
                                        $size = $item['product_size'];

                                        $product_total = number_format($item['product_total'], 2);
                                        $delivered = $item['delivered'];


                                        $product_Quantity = $item['product_Quantity'];



                                        $rate = number_format($item['product_rate'], 2);



                                        if ($delivered === $filter) {
                            ?>
                                            <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                                <div class="media d-block d-sm-flex text-center text-sm-left">
                                                    <a class="cart-item-thumb mx-auto mr-sm-4" href="#"><img src="  <?php echo $img; ?>" alt="Product" /></a>
                                                    <div class="media-body pt-3">
                                                        <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                                            <a href="#">
                                                                <?php echo $name; ?>

                                                            </a>
                                                        </h3>
                                                        <div class="font-size-sm">
                                                            <span class="text-muted mr-2">Size:</span>
                                                            <?php echo $size; ?>

                                                        </div>
                                                        <div class="font-size-sm">
                                                            <span class="text-muted mr-2">Color:</span>
                                                            <?php echo $color; ?>

                                                        </div>
                                                        <div class="font-size-sm">
                                                            <span class="text-muted mr-2">Quantity:</span>
                                                            <?php echo $product_Quantity; ?>
                                                        </div>
                                                        <div class="font-size-sm">
                                                            <span class="text-muted mr-2">Product Rate:</span>
                                                            <?php echo $rate; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 60rem">
                                                    <div>
                                                        <div class="font-size-lg text-primary pt-2">
                                                            
                                                            $<?php echo $product_total; ?>
                                                        </div>
                                                        <p>
                                                            <br>
                                                            <?php if ($filter === "Not Delivered") {

                                                            ?>
                                                                <span class="badge bg-danger rounded-pill"><?php echo $delivered; ?></span>
                                                            <?php } ?>
                                                            <?php if ($filter === "Delivered") {

                                                            ?>
                                                        <h4> <span class="badge bg-success rounded-pill"><?php echo $delivered; ?></span></h4>
                                                    <?php } ?> <?php if ($filter === "Returned") {

                                                                ?>
                                                        <h4> <span class="badge bg-primary rounded-pill"><?php echo $delivered.' & Refunded';  ?></span></h4>
                                                    <?php } ?>
                                                    </p>

                                                    </div>
                                                    <?php if ($filter === "Not Delivered") {

                                                    ?>
                                                        <form action="delete_product_cart.php" method="POST">
                                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                            <input type="hidden" name="item_index" value="<?php echo $key; ?>">
                                                            <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">

                                                            <button class="btn btn-outline-danger btn-sm btn-block mb-2" type="submit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 mr-1">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                </svg>cancel order
                                                            </button>
                                                        </form>

                                                    <?php } ?>

                                                </div>
                                            </div>
                        <?php


                                        }
                                    }
                                }
                            } else {
                                echo 'No rows found.';
                            }
                        }
                        ?>


                        <?php if ($filter === "Not Delivered") {

                            if ($total > 0) {



                        ?> <div class="row">
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">Subtotal</td>
                                                    <td class="text-end"><?php echo $total; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Shipping</td>
                                                    <td class="text-end">20.00</td>
                                                </tr>

                                                <tr class="fw-bold">
                                                    <td colspan="2">TOTAL</td>
                                                    <td class="text-end"><?php echo $total + 20; ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div><?php
                                    }
                                } ?>
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