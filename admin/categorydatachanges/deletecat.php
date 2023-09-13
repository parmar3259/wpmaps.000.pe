<?php

include('../../database/connection.php');


if (isset($_POST['delete'])) {
    $categoryId = $_POST['categoryId'];
    $imgPath = $_POST['imgPath'];

    // Delete category from the database
    $deleteSql = "DELETE FROM category WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteSql);
    mysqli_stmt_bind_param($deleteStmt, "i", $categoryId);
    if (mysqli_stmt_execute($deleteStmt)) {
        // Delete the uploaded image from the file system
        if (!empty($imgPath) && file_exists($imgPath)) {
            unlink($imgPath);
        }
        // echo "Category deleted successfully";
        header("Location: ../displayCategory.php");

    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }
}

?>