<?php 
    require_once("./sql_config.php");
    $error_msg="";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST['category_name'], $_POST['category_entrydate'], $_POST['product_code'], $_POST['product_entrydate'])){
            $category_name = trim($_POST['category_name']);
            $category_entrydate = trim($_POST['category_entrydate']);
            

            if(!empty($category_name) && !empty($category_entrydate)){
                $stmt = $conn ->prepare("INSERT INTO category(category_name, category_entrydate)
                            VALUES(?,?)
                ");
                $stmt -> bind_param("ss", $category_name, $category_entrydate);

                $success = $stmt->execute();
                $stmt->close();
                if($success){
                    header("location: show_list_category.php?msg=Table Record Creating Successfull!");
                    exit();
                }else{
                    $error_msg ="Table Record creating Failed!";
                }

            }else{
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
    <title>Add Product</title>
</head>
<body>
    <?php 
        if(!empty($error_msg)){

    ?>
        <div style="color: red; margin: 10px 0;">
            <?php echo htmlspecialchars($error_msg)?>
        </div>

    <?php
       }
    ?>    
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <label for="">Product Name</label>
        <input type="text" name="product_name" id="">
        <label for="">Product Category</label>
        <input type="text" name="product_category" id="">
        <label for="">Product Code</label>
        <input type="text" name="product_code" id="">
        <label for="">Product EntryDate</label>
        <input type="date" name="product_entrydate" id="">
        <button type="submit">Add Product</button>
    </form>
</body>
</html>