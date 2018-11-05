<?php include "scripts/awayIfNotAdmin.php"; ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8"/>
        <title>Администратор</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div class="admin_menu">
            <a href="users.php">Список пользователей</a></br>
            <a href="orders.php">Список заказов</a></br>
            <a href="goods.php">Список товаров</a></br>
            <a href="addGoods.php">Добавить товар</a></br>
            <a href="addCategories.php">Добавить категорию</a></br>
            <a href="categories.php">Удалить категорию</a></br>
            <a href="history.php">История заказов</a></br>
            <a href="scripts/logout.php">Выйти</a>
        </div>
    </body>

</html>