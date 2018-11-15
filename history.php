<?php
require_once "model/util/awayIfNotAdmin.php";
require_once "model/util/connectDB.php";
require_once "model/util/dao/HistoryRecordDao.php";
require_once "model/logic/URIResolver.php";
require_once "model/util/session.php";
require_once "model/util/utilFunc.php";
$uriRes = URIResolver::getURIResolver();
if ($uriRes->hasGET('delete_history'))
{
    $dao = new HistoryRecordDao($mysqli);
    $dao->deleteBy('id', $uriRes->getValue('delete_history'));
    gotoPage($uriRes->clearURI($_SERVER['REQUEST_URI']));
}

if ($uriRes->hasGET('clear_history'))
{
    $dao = new HistoryRecordDao($mysqli);
    $history = $dao->getAll();
    foreach ($history as $record)
    {
        $dao->delete($record);
    }
    gotoPage($uriRes->clearURI($_SERVER['REQUEST_URI']));
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
    </head>

    <body>
        <div class="list">
            <?php
            require_once "view/HistoryView.php";
            $view = new HistoryView();
            $view->viewAll($mysqli);
            ?>
        </div>
    </body>

</html>