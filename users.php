<?php
    require_once "model/util/awayIfNotAdmin.php";
    require_once "model/logic/URIResolver.php";
    require_once "model/util/utilFunc.php";
    $uriRes = URIResolver::getURIResolver();
    if ($uriRes->hasGET('delete_user'))
    {
        require_once "model/util/connectDB.php";
        require_once "model/util/dao/UserDao.php";
        $dao = new UserDao($mysqli);
        $dao->deleteBy('id', $uriRes->getValue('delete_user'));
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
        <form class="search">
            <input type="search" name="user_login" placeholder="Поиск пользователя">
            <input type="submit" value="найти">
        </form>

        <div class="list">
            <?php
            require_once "view/UserView.php";
            require_once "model/util/connectDB.php";
            $view = new UserView();
            $pattern = ($uriRes->hasGET('user_login')) ? "%" . $uriRes->getValue('user_login') . "%" : "%";/*(isset($_GET["user_login"])) ? "%" . $_GET["user_login"] . "%" : "%";*/
            $view->adminView($mysqli, $pattern);
            ?>
        </div>        
    </body>

</html>