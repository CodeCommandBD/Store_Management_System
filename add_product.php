<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['product_name'], $_POST['product_category'], $_POST['product_code'], $_POST['product_entrydate'])) {
        $product_name = sanitize_input($conn, $_POST['product_name']);
        $product_category = sanitize_input($conn, $_POST['product_category']);
        $product_code = sanitize_input($conn, $_POST['product_code']);
        $product_entrydate = sanitize_input($conn, $_POST['product_entrydate']);

        if (!empty($product_name) && !empty($product_category) && !empty($product_code) && !empty($product_entrydate)) {
            $stmt = $conn->prepare("INSERT INTO product(product_name, product_category, product_code, product_entrydate)
                            VALUES(?,?,?,?)
                ");
            if ($stmt) {
                $stmt->bind_param("ssss", $product_name, $product_category, $product_code, $product_entrydate);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("location: show_list_product.php?msg=Product Record Creating Successfull!");
                    exit();
                } else {
                    $error_msg = "Product Record creating Failed!";
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
    <title>Add Product</title>
</head>

<body>
    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg) ?>
        </div>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <label for="">Product Name</label>
        <br>
        <input type="text" name="product_name" id="">
        <br>
        <br>
        <label for="">Product Category</label>
        <br>
        <select name="product_category" id="">
            <option value="">Select your category</option>
            <?php echo get_dropdown_options($conn, 'category', 'category_id', 'category_name'); ?>
        </select>
        <br>
        <br>
        <label for="">Product Code</label>
        <br>
        <input type="text" name="product_code" id="">
        <br>
        <br>
        <label for="">Product EntryDate</label>
        <br>
        <input type="date" name="product_entrydate" id="">
        <br>
        <br>
        <button type="submit">Add Product</button>
    </form>
</body>

</html>