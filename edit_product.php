<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_category'], $_POST['product_code'], $_POST['product_entrydate'])) {
        $product_id = intval($_POST['product_id']);
        $product_name = trim($_POST['product_name']);
        $product_category = trim($_POST['product_category']);
        $product_code = trim($_POST['product_code']);
        $product_entrydate = trim($_POST['product_entrydate']);

        if ($product_id > 0 && !empty($product_name) && !empty($product_category) && !empty($product_code) && !empty($product_entrydate)) {
            $stmt = $conn->prepare("UPDATE product SET product_name = ?, product_category = ?, product_code = ?, product_entrydate = ? WHERE product_id = ?");
            if ($stmt) {
                // Corrected bind_param: s (name), i (category id), s (code), s (entrydate), i (product id)
                $stmt->bind_param("sissi", $product_name, $product_category, $product_code, $product_entrydate, $product_id);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("Location: show_list_product.php?msg=Record updated successfully");
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
    <title>Edit Product</title>
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
        $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
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

        <form action="edit_product.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['product_id']); ?>">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>">
            <label for="product_category">Product Category</label>
            <select name="product_category" id="product_category">
                <option value="">Select Category</option>
                <?php
                $cat_sql = "SELECT * FROM category";
                $run_cat = $conn->query($cat_sql);
                if ($run_cat->num_rows > 0) {
                    while ($cat_row = $run_cat->fetch_assoc()) {
                ?>
                        <option value="<?php echo htmlspecialchars($cat_row['category_id']); ?>" <?php if ($cat_row['category_id'] == $row['product_category']) { echo "selected"; } ?>>
                            <?php echo htmlspecialchars($cat_row['category_name']); ?>
                        </option>
                <?php
                    }
                }
                ?>
            </select>
            <label for="product_code">Product Code</label>
            <input type="text" name="product_code" id="product_code" value="<?php echo htmlspecialchars($row['product_code']); ?>">
            <label for="product_entrydate">Product EntryDate</label>
            <input type="date" name="product_entrydate" id="product_entrydate" value="<?php echo htmlspecialchars($row['product_entrydate']); ?>">
            <button type="submit">Update Product</button>
        </form>
    <?php
    } else {
        echo '<p>Product not found.</p>';
    }

    ?>



</body>

</html>