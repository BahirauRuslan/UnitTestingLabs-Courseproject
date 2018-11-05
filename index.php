<?php include "scripts/connectDB.php"; ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8"/>
        <title>Пекарь</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <header>
            <?php        
            //unset($_SESSION["logged_user"]);
            include "scripts/goToPage.php";
            include "model/checking.php";
            if (Checking::getChecking()->isAdmin()) {
                gotoPage("admin.php");
                //exit();
            } else {
                include "view/header.html";
                include Checking::getChecking()->getOneOf("view/authorizationControl.html", 
                    "view/userControl.html");
            }
            ?>
        </header>

        <div class="categories_panel">
            <?php include_once "view/createCategoriesTable.php"; ?>
        </div>
        
        <footer>
            <?php include_once "view/footer.html"; ?>
        </footer>
    </body>

</html>
