<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>show list category</title>
</head>

<body>
    <table>
        <tr class="header">
            <th>Category-ID</th>
            <th>Category_Name</th>
            <th>Category_Entrydate</th>
        </tr>


        <?php
        require_once("./sql_config.php");


        $query = "SELECT * FROM category";

        $result = $conn->query($query);


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

        ?>
                <tr>
                    <td><?php echo $row['category_id'] ?></td>
                    <td><?php echo $row['category_name'] ?></td>
                    <td><?php echo $row['category_entrydate'] ?></td>

                    <td>
                        <a href="edit.php?id=<?php $row['category_id'] ?>">EDIT</a>
                    </td>

                </tr>

        <?php
            }
        }
        ?>

    </table>






</body>

</html>