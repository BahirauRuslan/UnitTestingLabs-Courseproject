<?php require_once "model/util/session.php"; ?>
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
            require_once "model/util/utilFunc.php";
            require_once "model/logic/FaceControl.php";
            if (FaceControl::getFaceControl()->isAdmin()) {
                gotoPage("admin.php");
            } else {
                include "view/header.html";
                include FaceControl::getFaceControl()->getOneOf("view/authorizationControl.html",
                    "view/userControl.html");
            }
            ?>
        </header>

        <div class="categories_panel">
            <?php
            require_once "view/CategoryView.php";
            require_once "model/util/connectDB.php";
            $view = new CategoryView();
            $view->consumerView($mysqli);
            ?>
        </div>
        
        <footer>
            <?php include_once "view/footer.html"; ?>
        </footer>
    </body>

</html>
