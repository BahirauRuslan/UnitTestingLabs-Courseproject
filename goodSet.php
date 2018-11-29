<?php
require_once "model/logic/ProductVerifyer.php";
require_once "model/util/connectDB.php";
require_once "model/util/dao/ProductDao.php";
require_once "model/util/awayIfNotAdmin.php";
require_once "model/util/utilFunc.php";
require_once "view/paths.php";

if (isset($_POST["set_product"]))
{

    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    $errors_msg = array();
    $errors_msg["incorrect_name"] = "Некорректное название товара";
    $errors_msg["incorrect_price"] = "Некорректная цена товара";
    $errors_msg["big_description"] = "Слишком большое описание";
    $errors_msg["double_name"] = "Товар с таким названием уже существует";


    $verifyer = new ProductVerifyer($errors_msg);
    $error = $verifyer->productErrors($name, $price, $description, $mysqli);

    if (!$error && isset($_FILES["upload"]) && ($_FILES["upload"]["type"] == "image/jpeg"
            || $_FILES["upload"]["type"] == "image/png"))
    {
        $pic = $_FILES["upload"]["name"];
        $path = __DIR__ . "\\" . $PIC_PRODUCTS_PATH . $pic;
        if (!move_uploaded_file($_FILES["upload"]["tmp_name"], $path)) {
            echo "Изображение не было загружено";
        } else if (isset($_GET["category"])) {
            $dao = new CategoryDao($mysqli);
            $category = $dao->getBy("id", $_GET["category"])[0];
            $dao = new ProductDao($mysqli);
            $dao->add(new Product(0, $name, $category, $price, $description));
            $dao->updateColumnBy("name", $name, "picture_path", $pic);
            gotoPage("http://localhost:63342/courseproject/index.php");
        } else {
            $id = $_GET["product"];
            $dao = new ProductDao($mysqli);
            $product = $dao->getBy("id", $id)[0];
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $dao->update($product);
            $dao->updateColumnBy("name", $name, "picture_path", $pic);
            gotoPage("http://localhost:63342/courseproject/index.php");
        }
    } else if (!$error && isset($_FILES["upload"]) && $_FILES["upload"]["name"] != "" ) {
        echo "Данный тип файла не поддерживается";
    } else if (!$error) {
        if (isset($_GET["category"])) {
            $dao = new CategoryDao($mysqli);
            $category = $dao->getBy("id", $_GET["category"])[0];
            $dao = new ProductDao($mysqli);
            $dao->add(new Product(0, $name, $category, $price, $description));
        } else {
            $id = $_GET["product"];
            $dao = new ProductDao($mysqli);
            $product = $dao->getBy("id", $id);
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $dao->update($product);
        }
        gotoPage("http://localhost:63342/courseproject/index.php");
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
            <h2>Товар</h2>
            <p>Название товара<br><input type="text" name="name" autocomplete="off"></p>
            <p>Цена товара<br><input type="text" name="price" autocomplete="off"></p>
            <p>Описание<br><input type="text" name="description" autocomplete="off"></p>
            <p>Изображение<br><input type="file" name="upload" accept="image/jpeg"></p>
            <button type="submit" name="set_product">Подтвердить</button>
        </form>
    </body>

</html>