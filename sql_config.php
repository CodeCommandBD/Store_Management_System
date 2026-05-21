
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";


$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("server connecting error" . $conn->connect_error);
}


$query = "CREATE DATABASE IF NOT EXISTS $dbname";

if ($conn->query($query) === TRUE) {
    $conn->select_db($dbname);
} else {
    die("Error Creating Database: " . $conn->error);
}



// ৩. 💡 সবগুলো টেবিল তৈরির কুয়েরি একটি ডাইনামিক অ্যারেতে রাখা
$tables = [
    'category' => "CREATE TABLE IF NOT EXISTS category(
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(255) NOT NULL,
        category_entrydate DATE NOT NULL
    )",

    'product' => "CREATE TABLE IF NOT EXISTS product(
        product_id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(255) NOT NULL,
        product_category INT NULL,
        product_code VARCHAR(255) NOT NULL,
        product_entrydate DATE NOT NULL,
        FOREIGN KEY (product_category) REFERENCES category(category_id) ON DELETE SET NULL
    )",
    'store_product'=> "CREATE TABLE IF NOT EXISTS store_product(
        store_product_id INT AUTO_INCREMENT PRIMARY KEY,
        store_product_name INT NULL,
        store_product_quantity INT NOT NULL,
        store_product_entrydate DATE NOT NULL,
        FOREIGN KEY (store_product_name) REFERENCES product(product_id) ON DELETE SET NULL
    )",
    'spend_product'=> "CREATE TABLE IF NOT EXISTS spend_product(
        spend_product_id INT AUTO_INCREMENT PRIMARY KEY,
        spend_product_name INT NULL,
        spend_product_quantity INT NOT NULL,
        spend_product_entrydate DATE NOT NULL,
        FOREIGN KEY (spend_product_name) REFERENCES product(product_id) ON DELETE SET NULL
    )"

];


foreach ($tables as $tableName => $tableSql) {
    if ($conn->query($tableSql) === FALSE) {
        die("Error creating table '$tableName': " . $conn->error);
    }
}

// ==========================================
// 💡 reusable dynamic helper functions
// ==========================================

/**
 * Inputs sanitize logic to protect against SQL injections
 */
if (!function_exists('sanitize_input')) {
    function sanitize_input($conn, $data) {
        return mysqli_real_escape_string($conn, trim($data));
    }
}

/**
 * Generates select dropdown <option> list dynamically from a database table
 */
if (!function_exists('get_dropdown_options')) {
    function get_dropdown_options($conn, $table, $value_col, $text_col, $selected_value = null) {
        $options = "";
        $sql = "SELECT $value_col, $text_col FROM $table";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selected = ($selected_value !== null && $selected_value == $row[$value_col]) ? "selected" : "";
                $options .= "<option value='" . htmlspecialchars($row[$value_col]) . "' $selected>" . htmlspecialchars($row[$text_col]) . "</option>\n";
            }
        }
        return $options;
    }
}

