<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zay Shop - Product Detail Page</title>

    <?php
    include('./cssfiles.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    ?>

</head>

<body>
    <!-- Header -->
    <?php
    include('./navbar.php');
    ?>
    <!-- Close Header -->

    <!-- Modal -->
    <!-- <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div> -->



    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">

                    <?php
                    include('../database/connection.php');

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
                        $html_color = '<ul class="list-inline pb-3">';
                        $html_color .= '<li class="list-inline-item"> <h6>Avaliable Color: </h6></li>';
                        foreach ($size_array_color as $size) {
                            $html_color .= '<li class="list-inline-item"><input type="radio" name="product_color" value="' . $size . '" required> ' . $size . '</li>';
                        }
                        $html_color .= '</ul>';
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
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="<?php echo $path; ?>" alt="Card image cap" id="product-detail">
                    </div>

                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2"><?php echo $name; ?></h1>
                            <p class="h3 py-2">₹<?php echo $rates; ?></p>


                            <?php
                            if (isset($brand) && !empty($brand)) {

                            ?>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <h6>Brand:</h6>
                                    </li>
                                    <li class="list-inline-item">
                                        <p class="text-muted"><strong><?php echo $brand; ?></strong></p>
                                    </li>
                                </ul>
                            <?php
                            }

                            ?>


                            <h6>Description:</h6>
                            <p><?php echo $details; ?></p>
                     

                            <?php

                            if (isset($product_specification) && !empty($product_specification)) {
                            ?>
                            <!-- <li class="list-inline-item"> -->

                                <h6>Specification:</h6>
                                <!-- </li> -->
                                <li class="list-inline-item">

                                <spam><?php echo nl2br(htmlspecialchars($product_specification)); ?></spam>
                                </li>
                                <br><br>

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
                                    <div>
                                        <input type="hidden" name="quantity" id="product-quantity" value="1">
                                    </div>

                                </div>
                                <?php
                                if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {

                                ?>
                                    <div class="row pb-3">
                                      <div class="col d-grid">
                                            <button type="submit" class="btn btn-success btn-lg" name="addtocart" value="addtocart">Add To Cart</button>
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


                            <?php
                            if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {

                            ?>

                                <div class="row pb-3">

                                    <div class="col d-grid">
                                        <button class="btn btn-info btn-lg" onclick="redirectToCart()">View Cart</button>
                                    </div>


                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Related Products</h4>
            </div>

            <!--Start Carousel Wrapper-->
            <div id="carousel-related-product">
                <?php

                $sql = "SELECT * FROM products";
                $fetchproductresult = mysqli_query($conn, $sql);
                if (mysqli_num_rows($fetchproductresult) == 0) {
                    echo "<h1>No products to display</h1>";
                } else {


                    while ($row = mysqli_fetch_assoc($fetchproductresult)) {
                        $id = $row['product_id'];
                        $productImage = $row['product_image_path'];
                        $productImage = ltrim($productImage, '.');
                        $prefix = "../admin";
                        $path = $prefix . $productImage;




                ?>

                        <div class="p-2 pb-3">
                            <div class="product-wap card rounded-0 product-card">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="<?php echo $path; ?>">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-success text-white mt-2" href="shop-single.php?id=<?php echo $id; ?>"> View product</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="shop-single.php" class="h3 text-decoration-none"><?php echo $row['product_name']; ?></a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        <li>M/L/X/XL</li>
                                        <li class="pt-2">
                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0">₹<?php echo $row['product_rate']; ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

            </div>


        </div>
    </section>
    <!-- End Article -->

    <?php
    include('./footer.php');
    ?>
    <!-- Start Slider Script -->
    <script src="assets/js/slick.min.js"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });

        function redirectToCart() {
            window.location.href = "./cart.php";
        }
    </script>
    


    <!-- End Slider Script -->

</body>

</html>