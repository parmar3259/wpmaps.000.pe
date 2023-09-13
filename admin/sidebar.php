
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-flex">
            <img src="https://i.pinimg.com/originals/c2/ac/53/c2ac53c54fb5eb42b67b02fefb61f6ab.png" class="img-logo" alt="logo">

            <div class="brand-icons">
                <!-- <span class="las la-bell"></span> -->
                <a href="./profile.php">
                    <span class="las la-user-circle"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <div class="sidebar-user">
            <!-- <img src="https://randomuser.me/api/portraits/men/47.jpg" alt=""> -->
            <?php
                        include('../database/connection.php');

            if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {
                $fullname = $_SESSION['fullname'];
                $email = $_SESSION['email'];

                    $query = "SELECT roll FROM login WHERE fullname = '$fullname' AND email = '$email'";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $roll = $row['roll'];

                        if ($roll != 'admin') {
                            header("Location: ../user/index.php");

                      } 
                       
                    } else {
                        header("Location: ../user/index.php");
                    }

                    
            ?>
                <div>
                    <h3><?php echo "Welcome, $fullname";  ?></h3>
                    <span><?php echo "$email";  ?></span>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="sidebar-menu">
            <div class="menu-head">
                <span class="category">Dashboard</span>
                <ul>
                    <li><a href="./category.php"><span class="las la-balance-scale"></span>insert category</a></li>
                    <li><a href="./displayCategory.php"><span class="las la-balance-scale"></span>All category</a></li>

                    <li><a href="./insertProduct.php"><span class="lab la-jira"></span>Insert Product</a></li>
                    <li><a href="./upload_Product_Json.php"><span class="lab la-jira"></span>upload Product json</a></li>

                    <li><a href="./product.php"><span class="lab la-product-hunt"></span>products</a></li>
                    <li><a href="./orders.php"><span class="lab la-product-hunt"></span>orders</a></li>
                    <li><a href="./reset.php"><span class="lab la-product-hunt"></span>Reset website</a></li>


                    <!-- <li><a href="#"><span class="las la-balance-scale"></span>Calender</a></li>
                    <li><a href="#"><span class="las la-users"></span>Contacts</a></li>
                    <li><a href="#"><span class="las la-shopping-cart"></span>Ecommerce</a></li>
                    <li><a href="#"><span class="las la-envelope"></span>Mailbox</a></li>
                    <li><a href="#"><span class="las la-check-circle"></span>Tasks</a></li>
                    <li><a href="./user.php"><span class="lab la-jira"></span>users</a></li> -->


                </ul>
            </div>
<!-- 
            <div class="menu-head">
                <span class="category">Application</span>
                <ul>
                    


                </ul>
            </div> -->
        </div>
    </div>



</div>