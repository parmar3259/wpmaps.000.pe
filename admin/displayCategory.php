<?php include('./header.php');  ?>

<body>
    <?php include('./sidebar.php');  ?>

    <div class="main-content">
        <?php include('./navbar.php');  ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                        <h3>Admin &gt; <span class="highlight">Display Category</span></h3>
                    </div>
                </div>
                <style>
                    /* category page custom css */
                    .container1 {
                        padding: 20px;
                    }

                    .radius-15 {
                        border-radius: 15px;
                    }

                    .btn-white-custom {
                        background-color: #fff;
                        border-color: #e7eaf3;
                    }

                    .d-grid {
                        padding: 20px;
                    }

                    .bg-color-custom {
                        background-color: #7eb1db !important;
                    }

                    /* end */


                    /* end  */
                </style>

            </div>
            <section class="body">
                <!-- code for use to make pages -->
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                        <?php
                        include('../database/connection.php');

                        $sql = "SELECT * FROM category";
                        $fetchcatresult = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($fetchcatresult) == 0) {

                            echo "No category to display";
                       
                        } else {

                            while ($row = mysqli_fetch_assoc($fetchcatresult)) : ?>
                                <div class="col container1">
                                    <div class="card radius-15 bg-color-custom">
                                        <div class="card-body text-center">
                                            <div class="p-4 radius-15">
                                                <?php
                                                $imageSrc = $row['imgpath'];
                                                if ($row['upload_through'] == 'json') {
                                                    // Extract the file ID using regular expressions
                                                    $pattern = '/\/d\/(.*?)\//';
                                                    preg_match($pattern, $imageSrc, $matches);
                                                    if (isset($matches[1])) {
                                                        $fileId = $matches[1];
                                                        $imageSrc = 'https://drive.google.com/uc?id=' . $fileId;
                                                    }
                                                }
                                                ?>
                                                <img src="<?php echo $imageSrc; ?>" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">
                                                <h5 class="mb-0 mt-5 text-white">
                                                    <?php echo $row['catname']; 
                                                         echo  "<br>Category ID = ".$row['id'];
                                                    ?>

                                                </h5>
                                                <div class="d-grid">
                                                    <form method="post" action="./categorydatachanges/updatecat.php">
                                                        <input type="hidden" name="categoryId" value="<?php echo $row['id']; ?>">
                                                        <input type="hidden" name="imgPath" value="<?php echo $row['imgpath']; ?>">
                                                        <!-- Toggle switch -->
                                                        <div class="form-check form-switch mt-3">
                                                            <input class="form-check-input" type="checkbox" id="toggleSwitch" name="toggleSwitch" <?php echo ($row['cat_of_month'] == 1) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="toggleSwitch">
                                                                Toggle Me
                                                            </label>
                                                        </div>
                                                        <button type="submit" name="updateCategory" class="btn btn-white-custom radius-15 update-button">Update to page</button>
                                                    </form>

                                                    <!-- Add space between buttons -->
                                                    <div style="margin-top: 10px;"></div>

                                                    <form method="post" action="./categorydatachanges/deletecat.php">
                                                        <input type="hidden" name="categoryId" value="<?php echo $row['id']; ?>">
                                                        <input type="hidden" name="imgPath" value="<?php echo $row['imgpath']; ?>">
                                                        <button type="submit" name="delete" class="btn btn-white-custom radius-15">Delete Category</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                        <?php endwhile;
                        } ?>


                    </div>

                </div>
            </section>
        </main>
    </div>
    <label for="sidebar" class="body-label" id="body-label"></label>
</body>

</html>
<!-- partial -->
<?php include('./footer.php');  ?>

</body>

</html>