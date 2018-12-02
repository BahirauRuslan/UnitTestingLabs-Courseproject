<?php
require_once "model/logic/URIResolver.php";
require_once "model/util/utilFunc.php";
require_once "model/util/dao/CartDao.php";
require_once "model/util/session.php";
$uriRes = URIResolver::getURIResolver();
if ($uriRes->hasGET('delete_rec'))
{
    $dao = new CartDao();
    $dao->deleteById($uriRes->getValue('delete_rec'));
    gotoPage($uriRes->unsetFromURI($_SERVER['REQUEST_URI'], 'delete_rec'));
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8"/>
    <title>Корзина</title>
    <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
    <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
    <link href="view/css/items.css" rel="stylesheet" type="text/css"/>
</head>

<body>

    <header>
        <?php
        require_once "model/logic/FaceControl.php";
        if (!FaceControl::getFaceControl()->isAdmin())
        {
            include "view/header.html";
            include FaceControl::getFaceControl()->getOneOf("view/authorizationControl.html",
                "view/userControl.html");
        }
        ?>
    </header>

    <div class="list">
        <?php
        require_once "model/util/session.php";
        require_once "view/CartView.php";
        $view = new CartView();
        $view->view();
        ?>
    </div>
</body>

</html>