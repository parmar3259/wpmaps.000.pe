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
                <div class="col-xl-12 col-md-12 border shadow">
                        <h2 class="h6 d-flex flex-wrap justify-content-between align-items-center px-4 py-3 bg-secondary">
                            <span>Orders</span><a class="font-size-sm" href="./shop.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left" style="width: 1rem; height: 1rem">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>Continue shopping</a>
                        </h2>


                        <?php

                            ini_set('display_errors', 1);
                            ini_set('display_startup_errors', 1);
                            error_reporting(E_ALL);




                        // $sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND user_email = '$email'";
                        $sql = "SELECT * FROM orders WHERE user_id = '$user_id' AND user_email = '$email' ORDER BY order_id DESC";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {


                            while ($row = mysqli_fetch_assoc($result)) {
                    

                            
                                $invoice_id = $row['invoice_id'];
                                $date = $row['date'];

                                $cart_data = unserialize($row['cart_data']);
                                $cart_count = count($cart_data);


                                $total = 0;
                                foreach ($cart_data as $item) {
                    
                                
                                    if ($item['delivered'] === 'Not Delivered') {
                                        $quantity = $item['product_Quantity'];
                                        $rate = $item['product_rate'];
                                        $subtotal = $quantity * $rate;
                                        $total += $subtotal;
                                    }
                                }
                                


                                // echo "<pre>";   
                                // print_r();
                                // die;



                        ?>
                                        <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">
                                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                                <a class="cart-item-thumb mx-auto mr-sm-4" href="#"><img src="./assets/images/order_sample.jpg" alt="Product" /></a>
                                                <div class="media-body pt-3">
                                                    <h3 class="product-card-title font-weight-semibold border-0 pb-0">
                                                        <a href="#">
                                                        
                                                        </a>
                                                    </h3>
                                                    <div class="font-size-sm">
                                                        <span class="text-muted mr-2">Order has been placed</span>
                                                       
                                                    </div>
                                                    <div class="font-size-sm">
                                                        <span class="text-muted mr-2">No. Of Item</span>
                                                       <?php  echo $cart_count; ?>
                                                       
                                                    </div>
                                                    <div class="font-size-sm">
                                                        <span class="text-muted mr-2">Order Invoice Id :</span>
                                                       <?php  echo $invoice_id; ?>
                                                    </div>
                                                    <div class="font-size-sm">
                                                        <span class="text-muted mr-2">Order Recieved On :</span>
                                                       <?php  echo $date; ?>
                                                    </div>
                                                    


                                                </div>
                                            </div>
                                            <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left" style="max-width: 10rem">
                                                <div>
                                                    <?php           if ($total > 0) {  ?>
                                                  <div class="font-size-lg text-primary pt-2">
                                                       ₹<?php echo $total+20; ?>
                                                    </div>
                                                    <?php } ?>
                                                    <p>
                                                        <br>
                                                        <span class="badge bg-danger rounded-pill"></span>
                                                    </p>

                                                </div>
                                                <form action="./view_order.php" method="POST">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
                                                   

                                                    <button class="btn btn-outline-primary btn-sm btn-block mb-2" type="submit">
                                                       view order
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                        <?php
                                    // }
                                // }
                            }
                        } else {
                            echo 'No rows found.';
                        }
                        ?>


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