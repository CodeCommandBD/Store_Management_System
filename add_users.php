<?php 
require_once('./sql_config.php');
$error_msg = "";
$success_msg = "";

if (isset($_GET['msg'])) {
    $success_msg = $_GET['msg'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['user_name'], $_POST['user_email'], $_POST['pass_word'])) {
        $user_name = sanitize_input($conn, $_POST['user_name']);
        $user_email = sanitize_input($conn, $_POST['user_email']);
        $user_password = $_POST['pass_word'];
        $user_entrydate = date('Y-m-d'); // অটোমেটিক আজকের তারিখ

        if (!empty($user_name) && !empty($user_email) && !empty($user_password)) {
            // পাসওয়ার্ড হ্যাশ করা সিকিউরিটির জন্য (প্রফেশনাল স্ট্যান্ডার্ড)
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            
            $insert_data = [
                'user_name' => $user_name,
                'user_email' => $user_email,
                'user_password' => $hashed_password,
                'user_entrydate' => $user_entrydate
            ];

            if (insert_record($conn, 'users', $insert_data, 'ssss')) {
                header("Location: add_users.php?msg=User added successfully!");
                exit();
            } else {
                $error_msg = "User creation failed!";
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
    <title>Add Users</title>
</head>
<body>
    <h2>Add New User</h2>

    <?php if (!empty($error_msg)) { ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg) ?>
        </div>
    <?php } ?>

    <?php if (!empty($success_msg)) { ?>
        <div style="color: green; margin: 10px 0;">
            <?php echo htmlspecialchars($success_msg) ?>
        </div>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="user_name">Username: </label>
        <br>
        <input type="text" name="user_name" id="user_name">
        <br>
        <br>
        <label for="user_email">Email: </label>
        <br>
        <input type="email" name="user_email" id="user_email">
        <br>
        <br>
        <label for="pass_word">Password: </label>
        <br>
        <input type="password" name="pass_word" id="pass_word">
        <br><br>
        <input type="submit" value="Add User">
    </form>
</body>
</html>