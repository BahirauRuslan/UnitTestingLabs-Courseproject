<?php include "model/util/awayIfNotAdmin.php"; ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8"/>
        <title>Пользователи</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <form class="search">
            <input type="search" name="user_login" placeholder="Поиск пользователя">
            <input type="submit" value="найти">
        </form>

        <div class="users_list">
            <?php
            require_once "view\UserView.php";
            require_once "model/util/connectDB.php";
            $view = new UserView();
            $pattern = (isset($_GET["user_login"])) ? "%" . $_GET["user_login"] . "%" : "%";
            $view->adminView($mysqli, $pattern);
            ?>
        </div>        
    </body>

</html>