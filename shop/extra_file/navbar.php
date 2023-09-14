
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo">
    <img src="assets/images/logo.png" style="max-width: 100%; height: auto;">
</a>


                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="./index.php" class="active">Home</a></li>
                        <!-- <li class="scroll-to-section"><a href="#men">Men's</a></li>-->
                        <li class="scroll-to-section"><a href="./products.php">Products</a></li> 
                        <li class="scroll-to-section">
                            <a href="./cart.php">
                                <img src="./assets/images/svg/cart.svg" alt="Cart Icon"> Cart
                            </a>


                        </li>
                        <li class="submenu">
                            <a href="javascript:;">Others</a>
                            <ul>
                                <li><a href="about.php">About Us</a></li>
                                <!-- <li><a href="products.php">Products</a></li> -->
                                <!-- <li><a href="single-product.php">Single Product</a></li>    -->
                                <li><a href="contact.php">Contact Us</a></li>
                                
                                <?php
                                if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {
                                    $fullname = $_SESSION['fullname'];
                                    $email = $_SESSION['email'];
                                ?>
                                <li><a href="contact.php">My Orders</a></li>
                                <li><a href="wishlist.php">My WishList</a></li>
                                <?php
                                } else {
                                ?>


                                <li><a href="login.php">Login</a></li>

                                <?php
                                }
                                ?>

                            </ul>
                        </li>
                        <!-- <li class="submenu">
                            <a href="javascript:;">Features</a>
                            <ul>
                                <li><a href="#">Features Page 1</a></li>
                                <li><a href="#">Features Page 2</a></li>
                                <li><a href="#">Features Page 3</a></li>
                                <li><a rel="nofollow" href="https://templatemo.com/page/4" target="_blank">Template Page 4</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="scroll-to-section"><a href="#explore">Explore</a></li> -->
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>