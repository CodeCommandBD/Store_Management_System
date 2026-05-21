<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['store_product_id'], $_POST['store_product_name'], $_POST['store_product_quantity'], $_POST['store_product_entrydate'])) {
        $store_product_id = intval($_POST['store_product_id']);
        $store_product_name = sanitize_input($conn, $_POST['store_product_name']);
        $store_product_quantity = sanitize_input($conn, $_POST['store_product_quantity']);
        $store_product_entrydate = sanitize_input($conn, $_POST['store_product_entrydate']);

        if ($store_product_id > 0 && !empty($store_product_name) && !empty($store_product_quantity) && !empty($store_product_entrydate)) {
            $stmt = $conn->prepare("UPDATE store_product SET store_product_name = ?, store_product_quantity = ?, store_product_entrydate = ? WHERE store_product_id = ?");
            if ($stmt) {
                $stmt->bind_param("sssi", $store_product_name, $store_product_quantity, $store_product_entrydate, $store_product_id);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("Location: show_list_store_product.php?msg=Record updated successfully");
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
    <title>Edit Store Product</title>
</head>

<body>
    <h2>Edit Store Product</h2>

    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php } ?>

    <?php
    $row = null;
    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM store_product WHERE store_product_id = ?");
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
        <form action="edit_store_product.php" method="POST">
            <input type="hidden" name="store_product_id" value="<?php echo htmlspecialchars($row['store_product_id']); ?>">
            
            <label for="store_product_name">Select Product</label>
            <br>
            <select name="store_product_name" id="store_product_name">
                <option value="">Select your product</option>
                <?php echo get_dropdown_options($conn, 'product', 'product_id', 'product_name', $row['store_product_name']); ?>
            </select>
            <br><br>

            <label for="store_product_quantity">Store Product Quantity</label>
            <br>
            <input type="number" name="store_product_quantity" id="store_product_quantity" min="1" value="<?php echo htmlspecialchars($row['store_product_quantity']); ?>">
            <br><br>

            <label for="store_product_entrydate">Store Product EntryDate</label>
            <br>
            <input type="date" name="store_product_entrydate" id="store_product_entrydate" value="<?php echo htmlspecialchars($row['store_product_entrydate']); ?>">
            <br><br>

            <button type="submit">Update Store Product</button>
        </form>
    <?php
    } else {
        echo '<p>Store Product not found.</p>';
    }
    ?>
</body>

</html>