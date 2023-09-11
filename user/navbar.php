<!-- Start Top Nav -->
<nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
            </div>
            <div>
                <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
            </div>
        </div>
    </div>
</nav>
<!-- Close Top Nav -->




<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h2 align-self-center" href="index.php">
            Phulkarieva
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <!-- <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                            <div class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </div>
                        </div>
                    </div> -->
                <!-- <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                        <i class="fa fa-fw fa-search text-dark mr-2"></i>
                    </a> -->





                <?php
                if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {
                    $fullname = $_SESSION['fullname'];
                    $email = $_SESSION['email'];
                ?>

                    <a class="nav-icon position-relative text-decoration-none" href="./orders.php">
                        <img src="./assets/images/svg/order.png" alt="SVG Image" width="50px" height="50px">
                        <span
                            class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">orders</span>
                    </a>


                    <a class="nav-icon position-relative text-decoration-none" href="./cart.php">
                        <img src="./assets/images/svg/cart.svg" alt="SVG Image">

                        <?php

                        include('../database/connection.php');

                        $fullname = $_SESSION['fullname'];
                        $email = $_SESSION['email'];
                        $query = "SELECT id FROM login WHERE fullname = '$fullname' AND email = '$email'";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $user_id = $row['id'];
                        }
                        // Prepare the SQL statement to count data for the user
                        $sql = "SELECT COUNT(*) AS total_count FROM cartdata WHERE user_id = '$user_id'";

                        // Execute the query
                        $result = mysqli_query($conn, $sql);

                        // Fetch the result
                        $row = mysqli_fetch_assoc($result);

                        // Access the count
                        $total_count = $row['total_count'];

                      

                        ?>
<!-- Display the total count as a badge -->
<span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">
    <?php echo $total_count; ?>
</span>                    </a>


                    <a class="nav-icon position-relative text-decoration-none" href="../admin/logout.php">
                        <img src="./assets/images/svg/logout.svg" alt="SVG Image">
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">logout</span>
                    </a>

                <?php
                } else {
                ?>

                    <a class="nav-icon position-relative text-decoration-none" href="./login.php">
                        <img src="./assets/images/svg/login.svg" alt="SVG Image">
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                    </a>

                <?php
                }
                ?>


                <!-- <a class="nav-icon position-relative text-decoration-none" href="#">
                    <img src="./assets/images/svg/logout.svg" alt="SVG Image">
                    <span
                        class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                </a>


                <a class="nav-icon position-relative text-decoration-none" href="./login.php">
                    <img src="./assets/images/svg/login.svg" alt="SVG Image">
                    <span
                        class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                </a> -->
            </div>
        </div>

    </div>
</nav>