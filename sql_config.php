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





// ৩. ডাটাবেস চেক করা এবং সিলেক্ট করা
// এখানে select_db ফাংশনটি ডাটাবেস থাকলে সেটি সিলেক্ট করবে এবং TRUE রিটার্ন করবে।
// '!' চিহ্ন দিয়ে আমরা বলছি- "যদি ডাটাবেস সিলেক্ট করা না যায় (অর্থাৎ না থাকে)"
if (!$conn->select_db($dbname)) {
    
    // ডাটাবেস না থাকলে সেটি তৈরি করার SQL কমান্ড
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    
    // SQL কমান্ডটি রান করা এবং চেক করা যে এটি সফল হয়েছে কি না
    if ($conn->query($sql) === TRUE) {
        // সফলভাবে তৈরি হলে সেটি ব্যবহারের জন্য সিলেক্ট করা
        $conn->select_db($dbname);
    } else {
        // তৈরি করতে ব্যর্থ হলে এরর দেখানো
        die("Error creating database: " . $conn->error);
    }
}
