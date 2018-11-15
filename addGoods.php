<?php
require_once "model/util/awayIfNotAdmin.php";
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8"/>
        <title>Добавление товара</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div class="list">
            <?php
            require_once "view/CategoryView.php";
            require_once "model/util/connectDB.php";
            $view = new CategoryView();
            $view->adminSelectView($mysqli);
            ?>
        </div>
    </body>

</html>
