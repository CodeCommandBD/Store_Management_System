<?php 
    require_once('./sql_config.php');
    $query = "SELECT * FROM category";
    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Category List</title>
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
            <th>category_id</th>
            <th>category_name</th>
            <th>category_entrydate</th>
            <th colspan="2">Action</th>
        </tr>
        <?php 
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
        ?>

        <tr>
            <td><?php echo htmlspecialchars($row['category_id']) ?></td>
            <td><?php echo htmlspecialchars($row['category_name']) ?></td>
            <td><?php echo htmlspecialchars($row['category_entrydate']) ?></td>
            <td><a href="edit_category.php?id=<?php echo htmlspecialchars($row['category_id']) ?>">EDIT</a></td>
            <td><a href="delete_category.php?id=<?php echo htmlspecialchars($row['category_id']) ?>" onclick="return confirm('Delete this Category?')">Delete</a></td>

        </tr>
        <?php
                }
            }
        ?>

    </table>
</body>
</html>