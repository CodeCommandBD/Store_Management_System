<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['store_product_name'], $_POST['store_product_quantity'], $_POST['store_product_entrydate'])) {
        $product_id = sanitize_input($conn, $_POST['store_product_name']);
        $quantity = sanitize_input($conn, $_POST['store_product_quantity']);
        $entrydate = sanitize_input($conn, $_POST['store_product_entrydate']);

        if (!empty($product_id) && !empty($quantity) && !empty($entrydate)) {
            $stmt = $conn->prepare("INSERT INTO store_product(store_product_name, store_product_quantity, store_product_entrydate) VALUES(?,?,?)");
            if ($stmt) {
                $stmt->bind_param("iis", $product_id, $quantity, $entrydate);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("location: show_list_store_product.php?msg=Store Product Record Created Successfully!");
                    exit();
                } else {
                    $error_msg = "Store Product Record creating Failed!";
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
    <title>Add Store Product</title>
</head>

<body>
    <h2>Add Store Product (Inventory Stock)</h2>

    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg) ?>
        </div>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <label for="store_product_name">Select Product</label>
        <br>
        <select name="store_product_name" id="store_product_name">
            <option value="">Select your product</option>
            <?php echo get_dropdown_options($conn, 'product', 'product_id', 'product_name'); ?>
        </select>
        <br>
        <br>

        <label for="store_product_quantity">Store Product Quantity</label>
        <br>
        <input type="text" name="store_product_quantity" id="store_product_quantity" placeholder="Enter quantity">
        <br>
        <br>

        <label for="store_product_entrydate">Store Product EntryDate</label>
        <br>
        <input type="date" name="store_product_entrydate" id="store_product_entrydate">
        <br>
        <br>

        <button type="submit">Add Store Product</button>
    </form>
</body>

</html>