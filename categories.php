<?php
include "model/util/awayIfNotAdmin.php";
if (isset($_GET["delete_category"]))
{
    require_once "model/util/connectDB.php";
    require_once "model/util/dao/CategoryDao.php";
    require_once "view/paths.php";
    $dao = new CategoryDao($mysqli);
    $path = __DIR__ . "\\" . $PIC_CATEGORIES_PATH
        . $dao->getColumnBy('id', $_GET["delete_category"], "picture_path")[0];
    unlink($path);
    $dao->deleteBy('id', $_GET["delete_category"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8"/>
    <title>Категории</title>
    <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
    <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="view/css/categories.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div class="list">
        <?php
        require_once "view/CategoryView.php";
        require_once "model/util/connectDB.php";
        $view = new CategoryView();
        $view->adminView($mysqli);
        ?>
    </div>
</body>

</html>