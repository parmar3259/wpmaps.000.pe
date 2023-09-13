<?php include('./header.php');
?>

<body>
    <?php include('./sidebar.php'); ?>

    <div class="main-content">
        <?php include('./navbar.php'); ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                        <h3>Admin &gt; <span class="highlight">Category page</span></h3>

                    </div>
                </div>

            </div>
            <!-- <section class="body"> -->
            <?php

            // error_reporting(E_ALL);
            // ini_set('display_errors', 1);


            include('../database/connection.php');

            if (isset($_POST['submit'])) {
                $category = $_POST['catname'];
                $upload_dir = "./assets/uploads/";

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

                $stmt = mysqli_prepare($conn, "SELECT catname FROM category WHERE catname = ?");
                if (!$stmt) {
                    echo "Error preparing statement: " . mysqli_error($conn);
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "s", $category);
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Error executing statement: " . mysqli_error($conn);
                    exit();
                }

                mysqli_stmt_store_result($stmt);
                $num_rows = mysqli_stmt_num_rows($stmt);
                mysqli_stmt_close($stmt);

                if ($num_rows > 0) {
                    echo "Category already exists";
                    exit();
                }

                $stmt = mysqli_prepare($conn, "INSERT INTO category (catname, imgpath) VALUES (?, ?)");
                if (!$stmt) {
                    echo "Error preparing statement: " . mysqli_error($conn);
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "ss", $category, $image);
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Error inserting record: " . mysqli_error($conn);
                    exit();
                }

                echo "Category added successfully";
            }


            ?>


            <div class="center-div">

                <h2>Insert Data</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="category">Category</label>
                        <input type="text" required class="form-control" name="catname" id="category" aria-describedby="category" placeholder="Enter category">
                    </div>
                    <div class="mb-3">
                        <label for="image">Image</label>
                        <input class="form-control" type="file" required name="image" id="image">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
                <hr>
                <p>
                    You can insert one category at a time using the form above or insert multiple categories using JSON data.
                    <a href="./sampleJsonFormat/category.json" download>Download Sample JSON Data</a>
                </p>
                <hr>

                <h2>Upload JSON Data</h2>
                <div id="notice" class="text-danger"></div> <!-- Add a div for the notice -->
                <form id="jsonUploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="jsonFile" class="form-label">Choose a JSON file</label>
                        <input class="form-control" type="file" name="jsonFile" accept=".json" id="jsonFile" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="uploadJson" id="uploadJson">
                        <label class="form-check-label" for="uploadJson">Upload as JSON</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload JSON</button>
                </form>


            </div>

            <!-- </section> -->
        </main>
    </div>
    <label for="sidebar" class="body-label" id="body-label"></label>
</body>

</html>
<script>
    document.getElementById('jsonUploadForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);
        var isUploadJson = document.getElementById('uploadJson').checked;

        // Add the 'uploadJson' parameter to the form data
        formData.append('uploadJson', isUploadJson ? '1' : '0');

        $.ajax({
            type: 'POST',
            url: 'category_json_uploader.php', // Replace with the actual URL of your PHP script
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Update the notice content
                $('#notice').html("Insertion done"); // Assuming the response is the notice message

                // Optionally, clear the input field after success
                $('#jsonFile').val('');
            },
            error: function() {
                // Handle any errors that occur during the AJAX request
                alert('An error occurred during the AJAX request.');
            }
        });
    });
</script>


<!-- partial -->
<?php include('./footer.php'); ?>

</body>

</html>