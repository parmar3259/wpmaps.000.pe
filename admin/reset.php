<?php include('./header.php');  ?>

<body>
    <?php include('./sidebar.php');  ?>

    <div class="main-content">
        <?php include('./navbar.php');  ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                        <h3>Admin &gt; <span class="highlight">Reset Website</span></h3>
                    </div>
                </div>

            </div>
            <?php
                        include('../database/connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if the "reset" input value is "Yes"
    if ($_POST['reset'] === 'Yes') {
       
        // Truncate the "category" table
        $truncateCategoryTable = "TRUNCATE TABLE category";
        $truncateProductTable = "TRUNCATE TABLE products";

        if ($conn->query($truncateCategoryTable) === TRUE && $conn->query($truncateProductTable) === TRUE) {
            echo "truncated successfully.<br>";
        } else {
            echo "Error truncating category table: " . $conn->error . "<br>";
        }


        // Close the database connection
        $conn->close();
    } else {
        echo "Please enter 'Yes' to reset the database tables.";
    }
}
?>
            <section class="body">
                <div class="center-div">
                    <h2>Reset Website Database</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="category">Reset</label>
                            <input type="text" required class="form-control" name="reset" id="reset" aria-describedby="reset" placeholder="Enter Yes">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
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