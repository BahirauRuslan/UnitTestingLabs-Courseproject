<?php
require_once "model/util/awayIfNotAdmin.php";
require_once "model/logic/URIResolver.php";
require_once "model/util/utilFunc.php";
require_once "model/util/connectDB.php";
require_once "model/util/dao/OrderRecordDao.php";

$uriRes = URIResolver::getURIResolver();
if ($uriRes->hasGET('delete_order'))
{
    require_once "model/util/connectDB.php";
    $dao = new OrderRecordDao($mysqli);
    $dao->deleteBy('id', $uriRes->getValue('delete_order'));
    gotoPage($uriRes->clearURI($_SERVER['REQUEST_URI']));
}

if ($uriRes->hasGET("submit_order"))
{
    $dao = new OrderRecordDao($mysqli);
    $id = $uriRes->getValue("submit_order");
    $dao->updateColumnBy('id', $id, 'confirm_date', date('Y-m-d'));
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
    <link href="view/css/items.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div class="list">
        <?php
        require_once "view/OrderView.php";
        $view = new OrderView();
        $view->view($mysqli);
        ?>
    </div>
</body>

</html>
