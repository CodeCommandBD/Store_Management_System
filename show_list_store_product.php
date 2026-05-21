<?php
require_once('./sql_config.php');
$query = "SELECT sp.*, p.product_name 
          FROM store_product sp 
          LEFT JOIN product p ON sp.store_product_name = p.product_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Product List</title>
</head>
<body>
    <?php 
        if(!empty($_GET['msg'])){
    ?>
        <div>
            <?php echo htmlspecialchars($_GET['msg'])?>
        </div>

    <?php
       }
    ?> 

    <table border="1">
        <tr>
            <th>store_product_id</th>
            <th>store_product_name</th>
            <th>store_product_quantity</th>
            <th>store_product_entrydate</th>
            <th colspan="2">Action</th>
        </tr>
        <?php 
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
        ?>

        <tr>
            <td><?php echo htmlspecialchars($row['store_product_id']) ?></td>
            <td>
                <?php
                // Displaying the store product name instead of ID
                $product_name = ($row['product_name'] == NULL)? "N/A" : htmlspecialchars($row['product_name']);
                echo $product_name;
                ?>
            </td>

            <td><?php echo htmlspecialchars($row['store_product_quantity']) ?></td>
            <td><?php echo htmlspecialchars($row['store_product_entrydate']) ?></td>
            <td><a href="edit_store_product.php?id=<?php echo htmlspecialchars($row['store_product_id']) ?>">EDIT</a></td>
            <td><a href="delete_store_product.php?id=<?php echo htmlspecialchars($row['store_product_id']) ?>" onclick="return confirm('Delete this Product?')">Delete</a></td>

        </tr>
        <?php
                }
            }
        ?>

    </table>
</body>
</html>