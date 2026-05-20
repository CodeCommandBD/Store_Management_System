<?php 
    require_once('./sql_config.php');

    if(isset($_GET['id'])){
        $id = intval($_GET['id']);

        $stmt = $conn->prepare('DELETE FROM product WHERE product_id= ?');

        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        if($success){
            header("Location: show_list_product.php?msg=Record Delete successfully");
            exit();
        }else{
            header("Location: show_list_product.php?msg=Record Delete Failed!");
            exit();
        }
    }
    
?>