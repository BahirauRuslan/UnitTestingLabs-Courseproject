<?php
require_once "model/logic/CategoryVerifyer.php";
require_once "model/util/connectDB.php";
require_once "model/util/dao/CategoryDao.php";
require_once "model/util/awayIfNotAdmin.php";
require_once "view/paths.php";

if (isset($_POST["add_category"]))
{

    $name = $_POST["name"];
    $errors_msg = array();
    $errors_msg["incorrect_name"] = "Некорректное название категории";
    $errors_msg["double_name"] = "Категория с таким названием уже существует";

    $verifyer = new CategoryVerifyer($errors_msg);
    $error = $verifyer->categoryErrors($name, $mysqli);

    if (!$error && isset($_FILES["upload"]) && ($_FILES["upload"]["type"] == "image/jpeg"
            || $_FILES["upload"]["type"] == "image/png"))
    {
        $pic = $_FILES["upload"]["name"];
        $path = __DIR__ . "\\" . $PIC_CATEGORIES_PATH . $pic;
        if (!move_uploaded_file($_FILES["upload"]["tmp_name"], $path)) {
            echo "Изображение не было загружено";
        } else {
            $dao = new CategoryDao($mysqli);
            $dao->add(new Category(0, $name));
            $dao->updateColumnBy("name", $name, "picture_path", $pic);
        }
    } else if (!$error && isset($_FILES["upload"])) {
        echo "Данный тип файла не поддерживается";
    } else if (!$error) {
        $dao = new CategoryDao($mysqli);
        $dao->add(new Category(0, $name));
    } else {
        echo $error . '</br>';
    }

}
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
    <form action="" method="POST" class="user_identify" enctype="multipart/form-data">
        <h2>Новая категория</h2>
        <p>Название<br><input type="text" name="name"></p>
        <p>Изображение<br><input type="file" name="upload" accept="image/jpeg"></p>
        <button type="submit" name="add_category">Подтвердить</button>
    </form>
</body>

</html>