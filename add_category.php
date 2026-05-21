<?php 
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['category_name'], $_POST['category_entrydate'])) {
        $category_name = sanitize_input($conn, $_POST['category_name']);
        $category_entrydate = sanitize_input($conn, $_POST['category_entrydate']);

        if (!empty($category_name) && !empty($category_entrydate)) {
            $stmt = $conn->prepare("INSERT INTO category(category_name, category_entrydate) VALUES(?,?)");
            if ($stmt) {
                $stmt->bind_param("ss", $category_name, $category_entrydate);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("location: show_list_category.php?msg=Table Record Creating Successfull!");
                    exit();
                } else {
                    $error_msg = "Table Record creating Failed!";
                }
            } else {
                $error_msg = "Database statement preparation failed!";
            }
        } else {
            $error_msg = "সবগুলো ঘর পূরণ করা বাধ্যতামূলক!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg) ?>
        </div>
    <?php } ?>    
    <form action="add_category.php" method="POST">
        <label for="">Category Name</label>
        <input type="text" name="category_name" id="">
        <label for="">Category EntryDate</label>
        <input type="date" name="category_entrydate" id="">
        <button type="submit">Add Category</button>
    </form>
</body>
</html>