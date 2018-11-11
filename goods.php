<?php
require_once "model/logic/FaceControl.php";
if (isset($_GET["delete_product"]) && FaceControl::getFaceControl()->isAdmin())
{
    require_once "model/util/connectDB.php";
    require_once "model/util/dao/ProductDao.php";
    require_once "view/paths.php";
    $dao = new ProductDao($mysqli);
    $path = __DIR__ . "\\" . $PIC_PRODUCTS_PATH
        . $dao->getColumnBy('id', $_GET["delete_product"], "picture_path")[0];
    unlink($path);
    $dao->deleteBy('id', $_GET["delete_product"]);
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8"/>
        <title>Пользователи</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
        <link href="view/css/products.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div class="product_panel">
            <form class="search">
                <input type="search" name="product_name" placeholder="Поиск товара">
                <input type="submit" value="найти">
            </form>
            <a href="?sort_by=name&desc=
            <?php echo (isset($_GET['desc'])) ? !$_GET['desc'] : 'false' ?>">По названию</a>
            <a href="?sort_by=price&desc=
            <?php echo (isset($_GET['desc'])) ? !$_GET['desc'] : 'false' ?>">По цене</a>
            <?php
                require_once "view/ProductView.php";
                require_once "model/util/connectDB.php";
                require_once "model/logic/FaceControl.php";
                $view = new ProductView();
                $pattern = (isset($_GET["product_name"])) ? "%" . $_GET["product_name"] . "%" : "%";
                $sort_by = (isset($_GET["sort_by"])) ? $_GET["sort_by"] : "name";
                $desc = (isset($_GET["desc"])) ? (bool) $_GET["desc"] : false;
                if (FaceControl::getFaceControl()->isAdmin())
                {
                    $view->viewGoods($mysqli, $pattern, $sort_by, $desc);
                }
                else if (isset($_GET["category"]))
                {
                    $view->viewGoodsByCategory($mysqli, $pattern, $sort_by, $desc, $_GET["category"]);
                }
            ?>
        </div>
    </body>

</html>