<?php include('./header.php');  ?>

<body>
    <?php include('./sidebar.php');  ?>

    <div class="main-content">
        <?php include('./navbar.php');  ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                    <h3>Admin &gt; <span class="highlight">Insert Product Using JSON</span></h3>
                    </div>
                </div>

            </div>
            <section class="body">
                <div class="center-div">

                    <hr>
                    <p>
                        You can insert multiple Products using JSON data.
                        <a href="sample.json" download>Download Sample JSON Data</a>
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
            </section>
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
            url: 'product_json_uploader.php', // Replace with the actual URL of your PHP script
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
<?php include('./footer.php');  ?>

</body>

</html>