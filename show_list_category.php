<?php
require_once("./sql_config.php");

// লজিক উপরে রাখা ভালো
$query = "SELECT * FROM category";
$result = $conn->query($query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>show list category</title>
</head>

<body>
    <?php if (isset($_GET['msg'])): ?>
        <div class="msg-container">
            <div class="msg">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        </div>
    <?php endif; ?>
    <table border="1">
        <tr class="header">
            <th>Category-ID</th>
            <th>Category_Name</th>
            <th colspan="2">Category_Entrydate</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

        ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['category_id']) ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']) ?></td>
                    <td><?php echo htmlspecialchars($row['category_entrydate']) ?></td>
                    
                    <td><?php echo htmlspecialchars($row['category_entrydate']) ?></td>

                    <td><a href="./edit_category.php?id=<?php echo urlencode($row['category_id']) ?>">Edit</a></td>
                    
                    <td><a href="./delete_category.php?id=<?php echo urlencode($row['category_id']) ?>" onclick="return confirm('Delete this category?')">Delete</a></td>

                </tr>

        <?php
            }
        }
        ?>

    </table>






</body>

</html>