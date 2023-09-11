<?php
            include('../../database/connection.php');



if (isset($_POST['updateCategory'])) {
    $categoryId = $_POST['categoryId'];
    $status = isset($_POST['toggleSwitch']) ? 1 : 0;
    // Perform the database update
    $sql = "UPDATE category SET cat_of_month = $status WHERE id = $categoryId";
    if (mysqli_query($conn, $sql)) {
        // echo "updated category ";
        header("Location: ../displayCategory.php");

    }else{
        echo "Error updating category: " . mysqli_error($conn);
    }
}

?>