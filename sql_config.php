
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
    )"

    // ভবিষ্যতে আরও টেবিল লাগলে শুধু এখানে ১ লাইনে যুক্ত করে দেবেন!
];

// ৪. লুপের মাধ্যমে একবারে সব টেবিল তৈরি করা
foreach ($tables as $tableName => $tableSql) {
    if ($conn->query($tableSql) === FALSE) {
        die("Error creating table '$tableName': " . $conn->error);
    }
}
