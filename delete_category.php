<?php
require_once('./sql_config.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM category WHERE category_id= ?");

    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header('location: show_list_category.php?msg=Record delete successfully');
        exit();
    }else{
         header('location: show_list_category.php?msg=Failed to delete record');
    }
    $stmt->close();
}
