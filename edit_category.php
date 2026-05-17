<?php
require_once('./sql_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['category_name']) && isset($_POST['category_entrydate'])) {
        $id = $_GET['id'];
        $category_name = $_POST['category_name'];
        $category_entrydate = $_POST['category_entrydate'];

        $query = "UPDATE category SET category_name = ?, category_entrydate = ? 
                  WHERE category_id= ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $category_name, $category_entrydate, $id);

        if($stmt->execute()){
            header('location: show_list_category.php?msg=Record edit successfully');
        } else {
            header('location: show_list_category.php?msg=Failed to edit record');
        }

        $stmt->close();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>

<body>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];


        $query = "SELECT * FROM category WHERE category_id= ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {

    ?>
            <form action="edit_category.php?id=<?php echo $row['category_id'] ?>" method="POST">
                <label for="">Category Name:</label>
                <input type="text" name="category_name" id="" placeholder="Category Name" value="<?php echo $row['category_name'] ?>">

                <label for="">Category Entry Date:</label>
                <input type="date" name="category_entrydate" id="" placeholder="Category Entry Date" value="<?php echo date('Y-m-d', strtotime($row['category_entrydate'])) ?>">
                <button type="submit">update</button>
            </form>

    <?php
        }
    }
    ?>

</body>

</html>