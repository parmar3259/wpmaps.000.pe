<!DOCTYPE html>
<html lang="en">

<?php require('./extra_file/header.php');
     require('../database/connection.php');
     session_start();

?>

    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <?php require('./extra_file/navbar.php'); ?>

    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <!-- <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Single Product Page</h2>
                        <span>Awesome &amp; Creative HTML CSS layout by TemplateMo</span>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <!-- ***** Main Banner Area End ***** -->


    <!-- ***** Product Area Starts ***** -->
    <section class="section" id="product">
        <?php
         if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM products WHERE product_id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $name = $row['product_name'];
            $brand = $row['product_brand'];

            $details = $row['product_description'];
            $rates = $row['product_rate'];
            $color = $row['product_color'];
            $size_option = $row['size_option'];
            $product_size = $row['product_size'];
            $product_specification = $row['product_Specification'];

            $productImage = $row['product_image_path'];
            if ($row['upload_through'] == 'json') {
                // Extract the file ID using regular expressions
                $pattern = '/\/d\/(.*?)\//';
                preg_match($pattern, $productImage, $matches);
                if (isset($matches[1])) {
                  $fileId = $matches[1];
                  $path = 'https://drive.google.com/uc?id=' . $fileId;

                }
              }else{
                  $productImage = ltrim($productImage, '.');
                  $prefix = "../admin";
                  $path = $prefix . $productImage;
                }

                $size_array_color = explode(",", $color); // Split the string into an array based on commas

                $html_color = '<div class="form-group">';
                $html_color .= '<label for="product_color"><h6>Available Color:</h6></label>';
                $html_color .= '<select class="form-control" name="product_color" required>';
                
                foreach ($size_array_color as $size) {
                    $html_color .= '<option value="' . $size . '">' . $size . '</option>';
                }
                
                $html_color .= '</select>';
                $html_color .= '</div>';
                
                $output_color = $html_color;
                



            $size_array = explode(",", $product_size); // Split the string into an array based on commas
            $html = '<ul class="list-inline pb-3">';
            $html .= '<li class="list-inline-item"> <h6>Size :</h6></li>';
            foreach ($size_array as $size) {
                $html .= '<li class="list-inline-item"><input type="radio" name="product_size" value="' . $size . '" required> ' . $size . '</li>';
            }
            $html .= '</ul>';
            // Store the HTML code in a variable
            $output_html = $html;
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                <div class="left-images">
                    <!-- <img src="assets/images/single-product-01.jpg" alt=""> -->
                    <img src="<?php echo $path; ?>" alt="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content">
                    <h4><?php echo $name; ?></h4>
                    <span class="price">₹<?php echo $rates; ?></span>
                    <!-- <ul class="stars">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul> -->
                    <div class="details-container">
                    <?php
                            if (isset($brand) && !empty($brand)) {

                            ?>
                         <label>Brand Name :  <?php echo $brand; ?></label>
                         <br>
                         <?php
                            }

                            ?>
                         <label>Details:</label>
                        <span><?php echo $details; ?></span>
                    </div>
                    <?php

                        if (isset($product_specification) && !empty($product_specification)) {
                        ?>
                    <div class="quote">
                    <label>Product Specification:</label>

                        <i class="fa fa-quote-left"></i><p><?php echo nl2br(htmlspecialchars($product_specification)); ?></p>
                    </div>

                    <?php
                            }
                            ?>

        <form action="./cart/cartfunctionality.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $id; ?>">

            <div class="row">
                <div class="col-auto">
                    <?php echo $output_color; ?>
                </div>
                <div class="col-auto">
                    <!-- Size options -->
                    <?php if (isset($size_option) && $size_option == 'roman') { ?>
                        <?php echo $output_html; ?>
                    <?php } ?>

                    <?php if (isset($size_option) && $size_option == 'digit') { ?>
                        <?php echo $output_html; ?>
                    <?php } ?>
                </div>
            </div>
        <?php
                                        if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {

                                        ?>
            <div class="quantity-content">
                    <div class="left-content">
                        <h6>No. of Orders</h6>
                    </div>
                    <div class="right-content">
                        <div class="quantity buttons_added">
                            <input  name="quantity" id="product-quantity" type="number" step="1" min="1" max="" value="1" title="Qty"
                                class="input-text qty text" size="4" pattern="" inputmode="">
                        </div>
                    </div>
            </div>

            <div class="total">
                <!-- <h4>Total: $210.00</h4> -->
                <div class="col d-grid">
                    <button type="submit" class="btn btn-success btn-lg" name="addtocart" value="addtocart">Add To
                        Cart</button>
                </div>    
            </div>
            <?php
                                } else if (!isset($_SESSION['fullname'])) {
                                    echo '<div class="alert alert-danger" role="alert">';
                                    echo '<strong>Please login to proceed with your purchase.</strong>';
                                    echo '</div>';
                                    echo '<p><a href="login.php?id=' . $id . '" class="btn btn-primary">Click here to login</a></p>';
                                }
                                ?>

        
        </form>


                            

                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- ***** Product Area Ends ***** -->
    
    <!-- ***** Footer Start ***** -->
    <?php require('./extra_file/footer.php'); ?>
    <?php require('./extra_file/script.php'); ?>

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>

  </body>

</html>
