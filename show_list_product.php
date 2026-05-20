<?php
require_once('./sql_config.php');
$query = "SELECT p.*, c.category_name 
          FROM product p 
          LEFT JOIN category c ON p.product_category = c.category_id";
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
            <th>product_id</th>
            <th>product_name</th>
            <th>product_category</th>
            <th>product_code</th>
            <th>product_entrydate</th>
            <th colspan="2">Action</th>
        </tr>
        <?php 
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
        ?>

        <tr>
            <td><?php echo htmlspecialchars($row['product_id']) ?></td>
            <td><?php echo htmlspecialchars($row['product_name']) ?></td>

            <td>
                <?php
                // Displaying the category name instead of ID
                $cat_name = ($row['category_name'] == NULL)? "N/A" : htmlspecialchars($row['category_name']);
                echo $cat_name;
                ?>
            </td>

            <td><?php echo htmlspecialchars($row['product_code']) ?></td>
            <td><?php echo htmlspecialchars($row['product_entrydate']) ?></td>
            <td><a href="edit_product.php?id=<?php echo htmlspecialchars($row['product_id']) ?>">EDIT</a></td>
            <td><a href="delete_product.php?id=<?php echo htmlspecialchars($row['product_id']) ?>" onclick="return confirm('Delete this Product?')">Delete</a></td>

        </tr>
        <?php
                }
            }
        ?>

    </table>
</body>
</html>