<?php 
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="store_test";


    $conn  = new mysqli($servername, $username, $password);

    if($conn->connect_error){
        die("database connection Failed" . $conn->connect_error);
    }


    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    if($conn->query($sql) === TRUE){
        $conn->select_db($dbname);

        $table_sql = "CREATE TABLE IF NOT EXISTS category(
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(255) NOT NULL,
            category_entrydate DATE NOT NULL
        )";

        if($conn->query($table_sql) === TRUE){
            echo "table is ready";
        }else{
            die("table creating error" . $conn->error);
        }
    }else{
        die("database Creating error" . $conn->error);
    }