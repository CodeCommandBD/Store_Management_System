<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['category_id'], $_POST['category_name'], $_POST['category_entrydate'])) {
        $category_id = intval($_POST['category_id']);
        $category_name = trim($_POST['category_name']);
        $category_entrydate = trim($_POST['category_entrydate']);

        if ($category_id > 0 && !empty($category_name) && !empty($category_entrydate)) {
            $stmt = $conn->prepare("UPDATE category SET category_name = ?, category_entrydate = ? WHERE category_id = ?");
            if ($stmt) {
                $stmt->bind_param("ssi", $category_name, $category_entrydate, $category_id);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("Location: show_list_category.php?msg=Record updated successfully");
                    exit();
                } else {
                    $error_msg = "Table record update failed!";
                }
            } else {
                $error_msg = "Failed to prepare statement.";
            }
        } else {
            $error_msg = "সবগুলো ঘর পূরণ করা বাধ্যতামূলক!";
        }
    } else {
        $error_msg = "Invalid request.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
<?php } ?>

<?php
$row = null;
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
        }
        $stmt->close();
    }
}

if ($row) {

?>

            <form action="edit_category.php" method="POST">
                <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($row['category_id']); ?>">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" id="category_name" value="<?php echo htmlspecialchars($row['category_name']); ?>">
                <label for="category_entrydate">Category EntryDate</label>
                <input type="date" name="category_entrydate" id="category_entrydate" value="<?php echo htmlspecialchars($row['category_entrydate']); ?>">
                <button type="submit">Update Category</button>
            </form>
<?php
} else {
    echo '<p>Category not found.</p>';
}

?>



</body>

</html>