<?php
require('../database/connection.php');

$response = array(); // Initialize a response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a JSON file has been uploaded
    if (isset($_FILES["jsonFile"]) && $_FILES["jsonFile"]["error"] == 0) {
        // Get the uploaded JSON file content
        $jsonContent = file_get_contents($_FILES["jsonFile"]["tmp_name"]);
        $uploadJson = isset($_POST['uploadJson']) ? "json" : '0';

        // Parse the JSON data
        $jsonData = json_decode($jsonContent, true);

        // Check if the JSON data is valid
        if ($jsonData !== null) {
            // Iterate through the JSON data and insert/update it in the database
            foreach ($jsonData as $item) {
                $category_name = $conn->real_escape_string($item['category_name']);
                $image_url = $conn->real_escape_string($item['image_url']);
                $upload_through = $conn->real_escape_string($uploadJson);

                // Check if the employee already exists based on the email (assuming email is unique)
                $existingcategoryQuery = "SELECT * FROM category WHERE catname = '$category_name'";
                $existingcategoryResult = $conn->query($existingcategoryQuery);

                if ($existingcategoryResult->num_rows > 0) {
                    // Update the existing employee record
                    $updateQuery = "UPDATE category 
                                    SET catname = '$category_name', imgpath = '$image_url', upload_through = '$upload_through'
                                    WHERE catname = '$category_name'";
                    
                    if ($conn->query($updateQuery) === TRUE) {
                        $response[] = "Category updated successfully for $category_name";
                    } 
                } else {
                    // Insert data into the database table (employees)
                    $insertQuery = "INSERT INTO category (catname, imgpath, upload_through)
                                    VALUES ('$category_name', '$image_url', '$upload_through')";

                    if ($conn->query($insertQuery) === TRUE) {
                        $response[] = "Category inserted successfully for $category_name";
                    } 
                }
            }

            // Send a JSON response back to the client
            header('Content-Type: application/json');

            // print_r($response);
            echo json_encode($response);

        } else {
            $response[] = "Invalid JSON data.";
        }
    } else {
        $response[] = "Please select a JSON file to upload.";
    }
} else {
    $response[] = "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
