<?php include ('./header.php');  ?>
<style type="text/css">
  
      /* E-commerce */
      .product-box {
        padding: 0;
        border: 1px solid #e7eaec;
      }
      .product-box:hover,
      .product-box.active {
        border: 1px solid transparent;
        -webkit-box-shadow: 0 3px 7px 0 #a8a8a8;
        -moz-box-shadow: 0 3px 7px 0 #a8a8a8;
        box-shadow: 0 3px 7px 0 #a8a8a8;
      }
      .product-imitation {
        text-align: center;
        padding: 10px 0;
        background-color: #f8f8f9;
        color: #bebec3;
        font-weight: 600;
      }
      .cart-product-imitation {
        text-align: center;
        padding-top: 30px;
        height: 80px;
        width: 80px;
        background-color: #f8f8f9;
      }
      .product-imitation.xl {
        padding: 120px 0;
      }
      .product-desc {
        padding: 20px;
        position: relative;
      }
      .ecommerce .tag-list {
        padding: 0;
      }
      .ecommerce .fa-star {
        color: #d1dade;
      }
      .ecommerce .fa-star.active {
        color: #f8ac59;
      }
      .ecommerce .note-editor {
        border: 1px solid #e7eaec;
      }
      table.shoping-cart-table {
        margin-bottom: 0;
      }
      table.shoping-cart-table tr td {
        border: none;
        text-align: right;
      }
      table.shoping-cart-table tr td.desc,
      table.shoping-cart-table tr td:first-child {
        text-align: left;
      }
      table.shoping-cart-table tr td:last-child {
        width: 80px;
      }
      .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #676a6c;
        display: block;
        margin: 2px 0 5px 0;
      }
      .product-name:hover,
      .product-name:focus {
        color: #1ab394;
      }
      .product-price {
        font-size: 14px;
        font-weight: 600;
        color: #ffffff;
        background-color: #1ab394;
        padding: 6px 12px;
        position: absolute;
        top: -32px;
        right: 0;
      }
      .product-detail .ibox-content {
        padding: 30px 30px 50px 30px;
      }
      .image-imitation {
        background-color: #f8f8f9;
        text-align: center;
        padding: 200px 0;
      }
      .product-main-price small {
        font-size: 10px;
      }
      .product-images {
        margin: 0 20px;
      }

      .ibox {
        clear: both;
        margin-bottom: 25px;
        margin-top: 0;
        padding: 0;
      }
      .ibox.collapsed .ibox-content {
        display: none;
      }
      .ibox.collapsed .fa.fa-chevron-up:before {
        content: "\f078";
      }
      .ibox.collapsed .fa.fa-chevron-down:before {
        content: "\f077";
      }
      .ibox:after,
      .ibox:before {
        display: table;
      }
      .ibox-title {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background-color: #ffffff;
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 3px 0 0;
        color: inherit;
        margin-bottom: 0;
        padding: 14px 15px 7px;
        min-height: 48px;
      }
      .ibox-content {
        background-color: #ffffff;
        color: inherit;
        padding: 15px 20px 20px 20px;
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 1px 0;
      }
      .ibox-footer {
        color: inherit;
        border-top: 1px solid #e7eaec;
        font-size: 90%;
        background: #ffffff;
        padding: 10px 15px;
      }
    </style>
<body>
<?php include ('./sidebar.php');  ?>

    <div class="main-content">
    <?php include ('./navbar.php');  ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                    <h3>Admin &gt; <span class="highlight">Orders's page</span></h3>
                    </div>
                </div>
                
            </div>
            <section class="body">
<!-- code for use to make pages -->

<div class="container">
      <div class="row">

      <?php
      // Assuming you have a database connection established
include('../database/connection.php');

// Fetch all user IDs from the orders table
$query = "SELECT DISTINCT user_id FROM orders";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Loop through the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $userId = $row['user_id'];

        // Fetch user data from the login table based on the user ID
        $userDataQuery = "SELECT fullname, email, phone_number, user_address,user_address2 FROM login WHERE id = $userId";
        $userDataResult = mysqli_query($conn, $userDataQuery);

        // Check if the user data query was successful
        if ($userDataResult) {
            // Fetch the user data
            $userData = mysqli_fetch_assoc($userDataResult);



            // Display the user data
            // echo "User ID: " . $userId . "<br>";
            // echo "Full Name: " . $userData['fullname'] . "<br>";
            // echo "Email: " . $userData['email'] . "<br>";
            // echo "Phone Number: " . $userData['phone_number'] . "<br>";
            // echo "User Address: " . $userData['user_address'] . "<br>";
            // echo "<br>";

            ?>
            
        <div class="col-md-3">
          <div class="ibox">
            <div class="ibox-content product-box">
              <div class="product-imitation"><img src="./assets/images/person.png" alt="person image" style="width: 150px; height:150px"></div>
              <div class="product-desc">
                <!-- <span class="product-price"> $10 </span> -->
                <h6 class="product-name">User Name : <?php echo $userData['fullname'];  ?></h6>
                <h6 class="product-name"> email : <?php echo $userData['email'];  ?></h6>
                <h6 class="product-name"> Phonenumber : <?php echo $userData['phone_number'];  ?></h6>

                <h6 class="product-name"> Address : </h6>
                <div class="small m-t-xs">
                <?php echo $userData['user_address'];  ?>
                </div>
                <h6 class="product-name"> Address Landmark : </h6>
                <div class="small m-t-xs">
                <?php if(isset($userData['user_address2'])) {echo $userData['user_address2'];}  else { echo "No landmark"; } ?>
                </div>
                <div class="m-t text-righ">
                  <a href="./orders_detail.php?id=<?php echo $userId; ?>&email=<?php echo $userData['email']; ?>" class="btn btn-xs btn-outline btn-primary"
                    >Info <i class="fa fa-long-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

            <?php

            // Free the user data result set
            mysqli_free_result($userDataResult);
        } else {
            // Handle the error if the user data query fails
            echo "Error fetching user data: " . mysqli_error($connection);
        }
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the error if the main query fails
    echo "Error fetching user IDs: " . mysqli_error($connection);
}
      ?>

     
      </div>
    </div>






            </section>
        </main>
    </div>
    <label for="sidebar" class="body-label" id="body-label"></label>
</body>
</html>
<!-- partial -->
<?php include ('./footer.php');  ?>

</body>
</html>
