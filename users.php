<?php include "scripts/awayIfNotAdmin.php"; ?>
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
            <?php include "view\createUsersTable.php" ?>
        </div>        
    </body>

</html>