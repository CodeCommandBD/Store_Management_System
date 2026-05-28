<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['spend_product_name'], $_POST['spend_product_quantity'], $_POST['spend_product_entrydate'])) {
        $product_id = sanitize_input($conn, $_POST['spend_product_name']);
        $quantity = sanitize_input($conn, $_POST['spend_product_quantity']);
        $entrydate = sanitize_input($conn, $_POST['spend_product_entrydate']);

        if (!empty($product_id) && !empty($quantity) && !empty($entrydate)) {
            $insert_data = [
                'spend_product_name' => $product_id,
                'spend_product_quantity' => $quantity,
                'spend_product_entrydate' => $entrydate
            ];

            if (insert_record($conn, 'spend_product', $insert_data, 'iis')) {
                header("location: show_list_spend_product.php?msg=Spend Product Record Created Successfully!");
                exit();
            } else {
                $error_msg = "Spend Product Record creating Failed!";
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
    <title>Add Spend Product</title>
</head>

<body>
    <h2>Add Spend Product (Inventory Stock)</h2>

    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg) ?>
        </div>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <label for="spend_product_name">Select Product</label>
        <br>
        <select name="spend_product_name" id="spend_product_name">
            <option value="">Select your product</option>
            <?php echo get_dropdown_options($conn, 'product', 'product_id', 'product_name'); ?>
        </select>
        <br>
        <br>

        <label for="spend_product_quantity">Spend Product Quantity</label>
        <br>
        <input type="text" name="spend_product_quantity" id="spend_product_quantity" placeholder="Enter quantity">
        <br>
        <br>

        <label for="spend_product_entrydate">Spend Product EntryDate</label>
        <br>
        <input type="date" name="spend_product_entrydate" id="spend_product_entrydate">
        <br>
        <br>

        <button type="submit">Add Spend Product</button>
    </form>
</body>

</html>