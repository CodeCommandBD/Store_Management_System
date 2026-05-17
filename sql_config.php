<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'store_db';

// ১. সার্ভারে কানেক্ট করা
$conn = new mysqli($servername, $username, $password);

// ২. কানেকশন সফল হয়েছে কি না তা চেক করা
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}




$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

if ($conn->query($sql) === TRUE) {
    $conn->select_db($dbname);

    $table_sql = "CREATE TABLE IF NOT EXISTS category(
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(255) NOT NULL,
        category_entrydate DATE NOT NULL
    )";
    if ($conn->query($table_sql) === TRUE) {
        echo "Table is ready!"; 
    } else {
        die("Table creation failed: " . $conn->error);
    }
} else {
    die("Error Creating Data" . $conn->error);
}