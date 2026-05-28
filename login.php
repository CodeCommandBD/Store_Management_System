<?php 
session_start();
require_once('./sql_config.php');

$error_msg = "";
$success_msg = "";

if (isset($_GET['msg'])) {
    $success_msg = $_GET['msg'];
}

// যদি ইউজার ইতিমধ্যে লগইন করা থাকে, তবে তাকে প্রোডাক্ট লিস্ট পেজে রিডাইরেক্ট করে পাঠানো
if (isset($_SESSION['user_id'])) {
    header("Location: show_list_product.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['user_email'], $_POST['pass_word'])) {
        $user_email = sanitize_input($conn, $_POST['user_email']);
        // 💡 নোট: পাসওয়ার্ড স্যানিটাইজ করা যাবে না, কারণ পাসওয়ার্ডে থাকা বিশেষ চিহ্ন (\, ', ", ইত্যাদি) পরিবর্তিত হলে আসল পাসওয়ার্ডের সাথে মিলবে না।
        $user_password = $_POST['pass_word']; 

        if (!empty($user_email) && !empty($user_password)) {
            // ১. ডাটাবেসে ইমেইলটি আছে কিনা চেক করা
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
            if ($stmt) {
                $stmt->bind_param("s", $user_email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result && $result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    
                    // ২. পাসওয়ার্ড ভেরিফাই করা (password_verify)
                    if (password_verify($user_password, $user['user_password'])) {
                        // ৩. সেশন ভ্যারিয়েবল সেট করা
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['user_name'] = $user['user_name'];
                        $_SESSION['user_email'] = $user['user_email'];
                        
                        // ৪. সফল লগইন শেষে প্রোডাক্ট লিস্ট পেজে পাঠানো
                        header("Location: show_list_product.php?msg=Welcome " . urlencode($user['user_name']) . "! You are successfully logged in.");
                        exit();
                    } else {
                        $error_msg = "ভুল পাসওয়ার্ড! আবার চেষ্টা করুন।";
                    }
                } else {
                    $error_msg = "এই ইমেইল দিয়ে কোনো অ্যাকাউন্ট খুঁজে পাওয়া যায়নি!";
                }
                $stmt->close();
            } else {
                $error_msg = "ডাটাবেস কুয়েরি প্রিপেয়ার করতে ব্যর্থ হয়েছে!";
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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

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
        <label for="user_email">Email: </label>
        <br>
        <input type="email" name="user_email" id="user_email" required>
        <br>
        <br>
        <label for="pass_word">Password: </label>
        <br>
        <input type="password" name="pass_word" id="pass_word" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>