<?php
require_once('./sql_config2.php');
$query = "SELECT * FROM category";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>show Data in table</title>
</head>

<body>
    <?php if (!empty($_GET['error_msg'])): ?>
        <div>
            <?php echo htmlspecialchars($_GET['error_msg']) ?>
        </div>
    <?php endif; ?>
    <table border="1">
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Category EntryDate</th>
            <th colspan="2">Actions</th>
        </tr>


        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['category_id']) ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']) ?></td>
                    <td><?php echo htmlspecialchars($row['category_entrydate']) ?></td>
                    <td><a href="./edit_category2.php?id=<?php echo urlencode($row['category_id']) ?>">Edit</a></td>

                    <td><a href="./delete_category2.php?id=<?php echo urlencode($row['category_id']) ?>" onclick="return confirm('Delete this category?')">Delete</a></td>
                </tr>

        <?php
            }
        }
        ?>

    </table>

</body>

</html>