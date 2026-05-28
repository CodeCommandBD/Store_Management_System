<?php
require_once("./sql_config.php");
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['spend_product_id'], $_POST['spend_product_name'], $_POST['spend_product_quantity'], $_POST['spend_product_entrydate'])) {
        $spend_product_id = intval($_POST['spend_product_id']);
        $spend_product_name = sanitize_input($conn, $_POST['spend_product_name']);
        $spend_product_quantity = sanitize_input($conn, $_POST['spend_product_quantity']);
        $spend_product_entrydate = sanitize_input($conn, $_POST['spend_product_entrydate']);

        if ($spend_product_id > 0 && !empty($spend_product_name) && !empty($spend_product_quantity) && !empty($spend_product_entrydate)) {
            $stmt = $conn->prepare("UPDATE spend_product SET spend_product_name = ?, spend_product_quantity = ?, spend_product_entrydate = ? WHERE spend_product_id = ?");
            if ($stmt) {
                $stmt->bind_param("sssi", $spend_product_name, $spend_product_quantity, $spend_product_entrydate, $spend_product_id);
                $success = $stmt->execute();
                $stmt->close();
                if ($success) {
                    header("Location: show_list_spend_product.php?msg=Record updated successfully");
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
    <title>Edit Spend Product</title>
</head>

<body>
    <h2>Edit Spend Product</h2>

    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg); ?>
        </div>
    <?php } ?>

    <?php
    $row = null;
    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM spend_product WHERE spend_product_id = ?");
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
        <form action="edit_spend_product.php" method="POST">
            <input type="hidden" name="spend_product_id" value="<?php echo htmlspecialchars($row['spend_product_id']); ?>">
            
            <label for="spend_product_name">Select Product</label>
            <br>
            <select name="spend_product_name" id="spend_product_name">
                <option value="">Select your product</option>
                <?php echo get_dropdown_options($conn, 'product', 'product_id', 'product_name', $row['spend_product_name']); ?>
            </select>
            <br><br>

            <label for="spend_product_quantity">Spend Product Quantity</label>
            <br>
            <input type="number" name="spend_product_quantity" id="spend_product_quantity" min="1" value="<?php echo htmlspecialchars($row['spend_product_quantity']); ?>">
            <br><br>

            <label for="spend_product_entrydate">Spend Product EntryDate</label>
            <br>
            <input type="date" name="spend_product_entrydate" id="spend_product_entrydate" value="<?php echo htmlspecialchars($row['spend_product_entrydate']); ?>">
            <br><br>

            <button type="submit">Update Spend Product</button>
        </form>
    <?php
    } else {
        echo '<p>Spend Product not found.</p>';
    }
    ?>
</body>

</html>