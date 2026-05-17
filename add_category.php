 <?php
    require_once("./sql_config.php");
    $error_msg = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['category_name']) && isset($_POST['category_entrydate'])) {

            $category_name = trim($_POST['category_name']);
            $category_entrydate = trim($_POST['category_entrydate']);

            if (!empty($category_name) && !empty($category_entrydate)) {

                $stmt = $conn->prepare("INSERT INTO category (category_name, category_entrydate)
                                VALUES (?, ?)
        ");

                $stmt->bind_param("ss", $category_name, $category_entrydate);


                if ($stmt->execute()) {
                    header('location: show_list_category.php?msg=Record Add successfully');
                    exit();
                    
                } else {
                    $error_msg = 'Failed to add record: ' . $conn->error;
                }

                $stmt->close();
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
     <title>add category</title>
 </head>

 <body>


     <?php if (!empty($error_msg)): ?>
         <div style="color: red; margin: 10px 0;">
             <?php echo htmlspecialchars($error_msg) ?>
         </div>
     <?php endif; ?>



     <form action="add_category.php" method="POST">
         <label for="">Category Name:</label>
         <input type="text" name="category_name" id="" placeholder="Category Name">
         <label for="">Category Entry Date:</label>
         <input type="date" name="category_entrydate" id="" placeholder="Category Entry Date">
         <button type="submit">add category</button>
     </form>
 </body>

 </html>