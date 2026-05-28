<?php 
require_once('./sql_config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare('DELETE FROM spend_product WHERE spend_product_id = ?');
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        if ($success) {
            header("Location: show_list_spend_product.php?msg=Record Deleted successfully");
            exit();
        } else {
            header("Location: show_list_spend_product.php?msg=Record Deletion Failed!");
            exit();
        }
    }
}
?>





