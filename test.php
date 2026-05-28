<?php

// =============================
// 1. Upload folder (uploads/)
// =============================

// 👉 এখানে আমরা বলছি ফাইল কোথায় save হবে
// 👉 "uploads/" মানে server এর ভিতরে একটা folder
// 👉 final file এখানে store হবে

$uploadDir = "uploads/";


// =============================
// 2. Take file info ($_FILES থেকে data নেওয়া)
// =============================

// 👉 $_FILES হলো PHP এর special array
// 👉 এখানে uploaded file এর সব তথ্য থাকে

// 🔹 original file name (ইউজারের ফাইল নাম)
$fileName = $_FILES["fileToUpload"]["name"];

// 🔹 temporary file path (server এর temp memory location)
// 👉 file আগে এখানে আসে, তারপর move করা হয়
$fileTmp  = $_FILES["fileToUpload"]["tmp_name"];

// 🔹 file size (bytes এ আসে)
// 👉 কত বড় file upload হয়েছে
$fileSize = $_FILES["fileToUpload"]["size"];


// =============================
// 3. File extension বের করা (jpg/png etc)
// =============================

// 👉 pathinfo() file এর শেষ অংশ বের করে
// 👉 strtolower() সব ছোট হাতের করে দেয়

// Example:
// image.JPG → jpg

$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


// =============================
// 4. Allowed file types (security rule)
// =============================

// 👉 শুধু এই file গুলো allow করা হবে
// 👉 অন্য সব file block করা হবে

// 🔥 security reason:
// hacker যেন .php, .exe upload না করতে পারে

$allowed = ["jpg", "jpeg", "png", "gif"];


// =============================
// 5. Unique file name তৈরি (VERY IMPORTANT)
// =============================

// 👉 uniqid() নতুন unique ID তৈরি করে
// 👉 যাতে একই নামের file overwrite না হয়

// Example:
// IMG_65f8a9c3d12.jpg

$newFileName = uniqid("IMG_", true) . "." . $fileExt;


// 👉 final file path তৈরি করা হচ্ছে
// 👉 uploads/ + new file name

$targetPath = $uploadDir . $newFileName;


// =============================
// 6. Check: file আসল image কিনা
// =============================

// 👉 getimagesize() চেক করে file আসল image কিনা
// 👉 fake file (virus/script) block করার জন্য

// ❌ false → image না
// ✅ true → image

if (!getimagesize($fileTmp)) {

    // 👉 যদি image না হয় তাহলে script stop করে দেয়
    // 👉 die() মানে execution বন্ধ করে error দেখানো

    die("❌ File is not an image (ফাইলটি ছবি নয়)");
}


// =============================
// 7. Check: file already exists কিনা
// =============================

// 👉 একই নামের file আগে থেকে আছে কিনা check করে

// 📌 NOTE:
// এখানে আমরা random name ব্যবহার করছি
// তাই এটা rarely needed

if (file_exists($targetPath)) {

    die("❌ File already exists (ফাইল আগে থেকেই আছে)");
}


// =============================
// 8. Check: file size limit (1MB)
// =============================

// 👉 file যদি 1MB (1000000 bytes) এর বেশি হয়
// 👉 তাহলে reject করা হবে

// 📌 reason:
// server overload prevent করা

if ($fileSize > 1000000) {

    die("❌ File too large (Max 1MB) (ফাইল অনেক বড়)");
}


// =============================
// 9. Check: allowed file type
// =============================

// 👉 in_array() check করে file extension allowed কিনা

// Example:
// jpg আছে allowed list এ? → yes/no

if (!in_array($fileExt, $allowed)) {

    die("❌ Only JPG, JPEG, PNG, GIF allowed (শুধু ছবি ফাইল অনুমোদিত)");
}


// =============================
// 10. FINAL STEP: file move করা
// =============================

// 👉 move_uploaded_file()
// 👉 temp location থেকে final folder এ file পাঠায়

// 🔥 খুব গুরুত্বপূর্ণ:
// এটা ছাড়া file save হবে না

if (move_uploaded_file($fileTmp, $targetPath)) {

    // ✅ success হলে

    echo "✅ Upload successful (আপলোড সফল হয়েছে)!<br>";

    // 👉 নতুন generated file name দেখানো
    echo "File name: " . $newFileName;

} else {

    // ❌ যদি move fail হয়

    echo "❌ Upload failed (আপলোড ব্যর্থ হয়েছে)";
}

?>