<?php
// Assuming you have a database connection established
include('../database/connection.php');

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_image_path = $_POST['product_image_path'];

    // Fetch the product's upload path from the database
    $query = "SELECT upload_through FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $upload_through);
            mysqli_stmt_fetch($stmt);
            
            // Check if the upload_through is 'json'; if yes, skip image deletion
            if ($upload_through !== 'json') {
                // Perform the deletion in the database
                $deleteQuery = "DELETE FROM products WHERE product_id = ?";
                $deleteStmt = mysqli_prepare($conn, $deleteQuery);
                mysqli_stmt_bind_param($deleteStmt, 'i', $product_id);

                if (mysqli_stmt_execute($deleteStmt)) {
                    // Delete the associated image file (ensure correct file path and permissions)
                    if (unlink($product_image_path)) {
                        // Return a success message
                        echo json_encode(['success' => true]);
                        exit; // Stop execution after successful deletion
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed to delete image']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Deletion failed']);
                }
            } else {
                // Product has 'json' as upload_through, skip image deletion
                echo json_encode(['success' => true, 'message' => 'Product deleted (image not deleted)']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Product not found']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Database query error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing product_id']);
}
?>
