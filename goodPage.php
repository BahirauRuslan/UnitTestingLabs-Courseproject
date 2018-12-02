<?php
require_once "model/logic/FaceControl.php";
require_once "model/logic/URIResolver.php";
require_once "model/util/utilFunc.php";
require_once "model/util/connectDB.php";

$uriRes = URIResolver::getURIResolver();

if ($uriRes->hasGET("add_product"))
{
    require_once "model/util/dao/CartDao.php";
    require_once "model/util/dao/ProductDao.php";
    require_once "model/util/session.php";
    $dao = new CartDao();
    $id = $uriRes->getValue("add_product");
    if ($dao->getBy($id))
    {
        $record = $dao->getBy($id);
        $record->setCount($record->getCount() + 1);
        $dao->update(array($record));
    }
    else
    {
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
        <title>Товар</title>
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
        <div class="product_page">
            <?php
                require_once "view/ProductView.php";

                $view = new ProductView();
                if ($uriRes->hasGET("product_id")) {
                    $view->viewPage($mysqli,
                        $uriRes->getValue("product_id"),
                        FaceControl::getFaceControl()->isAdmin());
                }
            ?>
        </div>
    </body>

</html>