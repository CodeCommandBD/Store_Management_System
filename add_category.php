<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add category</title>
</head>
<body>
    <?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['category_name']) && isset($_POST['category_entrydate'])){
        require_once("./sql_config.php");

        $category_name = $_POST['category_name'];
        $category_entrydate = $_POST['category_entrydate'];


        $stmt = $conn->prepare("INSERT INTO category (category_name, category_entrydate)
                                VALUES (?, ?)
        ");

        // ডাটা বাইন্ড করা
        $stmt->bind_param("ss",$category_name, $category_entrydate);

        // এখানে execute() রান হবে এবং রেজাল্ট চেক করবে
        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        } else {
            echo "Data not inserted. Error: " . $stmt->error;
        }

        $stmt->close();

        
    }
}
    
    ?>



    <form action="add_category.php" method="POST">
        <label for="">Category Name:</label>
        <input type="text" name="category_name" id="" placeholder="Category Name">
        <label for="">Category Entry Date:</label>
        <input type="date" name="category_entrydate" id="" placeholder="Category Entry Date">
        <button type="submit">add category</button>
    </form>
</body>
</html>