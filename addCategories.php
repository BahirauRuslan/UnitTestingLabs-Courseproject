<?php
include "model/util/awayIfNotAdmin.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8"/>
    <title>Добавить категорию</title>
    <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
    <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <form action="" method="POST" class="user_identify">
        <h2>Новая категория</h2>
        <p>Название<br><input type="text" name="login"></p>
        <button type="submit" name="add_category">Подтвердить</button>
    </form>
</body>

</html>