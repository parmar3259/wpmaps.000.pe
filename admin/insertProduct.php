<?php include('./header.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<style type="text/css">
    .card {
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

    .card-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.5rem 1.5rem;
    }
</style>

<body>
    <?php include('./sidebar.php');  ?>

    <div class="main-content">
        <?php include('./navbar.php');  ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                        <h3>Admin &gt; <span class="highlight">Insert Product page</span></h3>
                    </div>
                </div>

            </div>
            <section class="body">
                <!-- code for use to make pages -->
                <div class="container-fluid">
                    <div class="container">

                        <?php
                        include('../database/connection.php');

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                          
                            // Retrieve form data
                            $productName = $_POST['productName'];
                            $brand = $_POST['productBrand'];

                            $category_name = $_POST['category_name'];
                            $sizeOption = $_POST['sizeOption'];
                            $size = ($sizeOption == 'digit') ? $_POST['sizeDigit'] : $_POST['sizeRoman'];
                            $rate = $_POST['rate'];
                            $color = $_POST['color'];
                            $description = $_POST['description'];
                            $Specification = $_POST['Specification'];


                            // Process the uploaded image
                            $upload_dir = "./assets/uploads/products/";

                            if (!file_exists($upload_dir) && !mkdir($upload_dir, 0777, true)) {
                                echo "Failed to create upload directory.";
                                exit();
                            }
            
                            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                                $file_name = $_FILES['image']['name'];
                                $file_tmp = $_FILES['image']['tmp_name'];
                                $file_size = $_FILES['image']['size'];
                                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                                $extensions = array("jpg", "jpeg", "png", "gif");
            
                                if (!in_array($file_ext, $extensions)) {
                                    echo "Extension not allowed, please choose a JPG, JPEG, PNG, or GIF file.";
                                    exit();
                                } elseif ($file_size > 2097152) {
                                    echo "File size must be exactly or less than 2 MB";
                                    exit();
                                }
            
                                $upload_path = $upload_dir . $file_name;
                                if (!move_uploaded_file($file_tmp, $upload_path)) {
                                    echo "Error uploading file.";
                                    exit();
                                }
            
                                $image = $upload_path;
                            } else {
                                $image = null;
                            }

                            // Insert data into the database
                            $query = "INSERT INTO products (product_name, product_brand, category_name, size_option, product_size, product_rate, product_color, product_description, product_Specification, product_image_path) 
              VALUES ('$productName', '$brand' , '$category_name', '$sizeOption', '$size', '$rate', '$color', '$description', '$Specification', '$image')";
                            if (mysqli_query($conn, $query)) {
                                echo "Data inserted successfully.";
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                        }
                        $sql = "SELECT * FROM category";
                        $fetchcatresult = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($fetchcatresult) == 0) {

                            echo "Create category First";
                       
                        } else {
                        ?>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h3 class="h6 mb-4">Basic information</h3>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product name*</label>
                                                        <input type="text" class="form-control" name="productName" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Brand</label>
                                                        <input type="text" class="form-control" name="productBrand" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">

                                                    <div class="mb-3">
                                                        <label class="form-label">Select Category:</label>
                                                        <select class="form-control" name="category_name">
                                                            <?php
                                                            $query = "SELECT * FROM category";
                                                            $result = mysqli_query($conn, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $categoryId = $row['id'];
                                                                $categoryName = $row['catname'];
                                                                echo "<option value='$categoryName'>$categoryName</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h3 class="h6 mb-4">Basic Details</h3>
                                            <div class="mb-3">
                                                <h5>Select the size:*</h5>
                                                <input class="form-check-input" type="radio" name="sizeOption" id="sizeDigit" value="digit">
                                                <label class="form-check-label" for="sizeDigit">
                                                    Digit
                                                </label>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="form-check-input" type="radio" name="sizeOption" id="sizeRoman" value="roman">
                                                <label class="form-check-label" for="sizeRoman">
                                                    Roman
                                                </label>
                                            </div>
                                            <div id="digitField" class="mb-3" style="display: none;">
                                                <label class="form-label">Size available in digit (e.g., 22, 44, 36)</label>
                                                <input type="text" class="form-control" name="sizeDigit">
                                            </div>
                                            <div id="romanField" class="mb-3" style="display: none;">
                                                <label class="form-label">Size available in roman (e.g., XL, L, XXL)</label>
                                                <input type="text" class="form-control" name="sizeRoman">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Rate Of Product*</label>
                                                        <input type="text" class="form-control" name="rate" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Color</label>
                                                        <input type="text" class="form-control" name="color">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <!-- <h3 class="h6 mb-4">Product Details*</h3> -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product description*</label>
                                                        <textarea class="form-control" name="description" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Specification</label>
                                                        <textarea class="form-control" name="Specification" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h3 class="h6">Upload product Image</h3>
                                            <input class="form-control" type="file" name="image" id="imageInput" >
                                            <div id="imagePreview"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="Cancle" class="btn btn-light">Cancel</button>
                                </div>


                            </div>

                        </form>
<?php }?>
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
<script>
    $(document).ready(function() {
        // When a radio button is clicked
        $('input[name="sizeOption"]').on('change', function() {
            var selectedOption = $(this).val();

            // Hide both fields initially
            $('#digitField').hide();
            $('#romanField').hide();

            // Show the corresponding field based on the selected option
            if (selectedOption === 'digit') {
                $('#digitField').show();
            } else if (selectedOption === 'roman') {
                $('#romanField').show();
            }
        });
    });

    // JavaScript
    document.getElementById('imageInput').addEventListener('change', function(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var imgElement = document.createElement('img');
            imgElement.src = reader.result;
            imgElement.style.maxWidth = '300px';
            imgElement.style.maxHeight = '300px';
            imgElement.style.border = '1px solid #ccc';
            imgElement.style.padding = '10px';

            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';
            previewContainer.appendChild(imgElement);
        };

        reader.readAsDataURL(input.files[0]);
    });
</script>

</body>

</html>