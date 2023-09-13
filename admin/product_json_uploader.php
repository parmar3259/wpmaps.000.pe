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
                // Retrieve product data from JSON
                $productName = $conn->real_escape_string($item['product_name']);
                $brand = $conn->real_escape_string($item['product_brand']);
                $category_name = $conn->real_escape_string($item['category_name']);
                $sizeOption = $conn->real_escape_string($item['size_option']);
                $size = ($sizeOption == 'digit') ? $conn->real_escape_string($item['product_size_digit']) : $conn->real_escape_string($item['product_size_roman']);
                $rate = $conn->real_escape_string($item['product_rate']);
                $color = $conn->real_escape_string($item['product_color']);
                $description = $conn->real_escape_string($item['product_description']);
                $Specification = $conn->real_escape_string($item['product_Specification']);
                $image = $conn->real_escape_string($item['product_image_path']);
                $upload_through = $conn->real_escape_string($uploadJson);

                // Check if the product already exists based on some unique identifier (e.g., product_name)
                $existingProductQuery = "SELECT * FROM products WHERE product_name = '$productName'";
                $existingProductResult = $conn->query($existingProductQuery);

                if ($existingProductResult->num_rows > 0) {
                    // Update the existing product record
                    $updateQuery = "UPDATE products 
                                    SET product_brand = '$brand', category_name = '$category_name', size_option = '$sizeOption', 
                                    product_size = '$size', product_rate = '$rate', product_color = '$color', 
                                    product_description = '$description', product_Specification = '$Specification', 
                                    product_image_path = '$image', upload_through = '$upload_through' WHERE product_name = '$productName'";
                    
                    if ($conn->query($updateQuery) === TRUE) {
                        $response[] = "Product updated successfully for $productName";
                    } 
                } else {
                    // Insert data into the products table
                    $insertQuery = "INSERT INTO products (product_name, product_brand, category_name, size_option, 
                                    product_size, product_rate, product_color, product_description, product_Specification, 
                                    product_image_path,upload_through)
                                    VALUES ('$productName', '$brand', '$category_name', '$sizeOption', '$size', '$rate', '$color', 
                                    '$description', '$Specification', '$image','$upload_through')";

                    if ($conn->query($insertQuery) === TRUE) {
                        $response[] = "Product inserted successfully for $productName";
                    } 
                }
            }

            // Send a JSON response back to the client
            header('Content-Type: application/json');
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
