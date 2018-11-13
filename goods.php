<?php
require_once "model/logic/FaceControl.php";
require_once "model/logic/URIResolver.php";
require_once "model/util/utilFunc.php";
$uriRes = URIResolver::getURIResolver();
if ($uriRes->hasGET("delete_product") && FaceControl::getFaceControl()->isAdmin())
{
    require_once "model/util/connectDB.php";
    require_once "model/util/dao/ProductDao.php";
    require_once "view/paths.php";
    $dao = new ProductDao($mysqli);
    if (isset($dao->getColumnBy('id',
            $uriRes->getValue("delete_product"), "picture_path")[0]))
    {
        $path = __DIR__ . "\\" . $PIC_PRODUCTS_PATH
            . $dao->getColumnBy('id',
                $uriRes->getValue("delete_product"), "picture_path")[0];
        unlink($path);
    }
    $dao->deleteBy('id', $uriRes->getValue("delete_product"));
}

if ($uriRes->hasGET("add_product"))
{
    require_once "model/util/dao/CartDao.php";
    require_once "model/util/dao/ProductDao.php";
    $dao = new CartDao();
    $id = $uriRes->getValue("add_product");
    if (isset($dao->getBy($id)[0]))
    {
        $record = $dao->getBy($id)[0];
        $record->setCount($record->getCount() + 1);
        $dao->update(array($record));
    }
    else
    {
        require_once "model/util/connectDB.php";
        $daoProd = new ProductDao($mysqli);
        if (isset($daoProd->getBy('id', $id)[0])) {
            $dao->add(array(new CartRecord($daoProd->getBy('id', $id)[0], 1)));
        }
    }
    gotoPage($uriRes->unsetFromURI($_SERVER['REQUEST_URI'], 'add_product'));
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
        <header>
            <?php
            if (!FaceControl::getFaceControl()->isAdmin())
            {
                include "view/header.html";
                include FaceControl::getFaceControl()->getOneOf("view/authorizationControl.html",
                    "view/userControl.html");
            }
            ?>
        </header>
        <div class="product_panel">
            <form class="search">
                <input type="search" name="product_name" placeholder="Поиск товара">
                <input type="submit" value="найти">
            </form>
            <a href="
                <?php
                    $uri = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                        'sort_by', 'name');
                    $desc = ($uriRes->hasGET('desc')) ? !$uriRes->getValue('desc') : false;
                    $uri = $uriRes->setToURI($uri, 'desc', $desc);
                    echo $uri;
                ?>">По названию</a>

            <a href="
                <?php
                    $uri = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                        'sort_by', 'price');
                    $desc = ($uriRes->hasGET('desc')) ? !$uriRes->getValue('desc') : false;
                    $uri = $uriRes->setToURI($uri, 'desc', $desc);
                    echo $uri;
                ?>">По цене</a>
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