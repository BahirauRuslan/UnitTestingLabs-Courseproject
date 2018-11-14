<?php
require_once "model/util/session.php";
require_once "model/util/connectDB.php";
require_once "model/util/utilFunc.php";
require_once "model/util/dao/UserDao.php";
require_once "model/util/dao/CartDao.php";
require_once "model/util/dao/OrderRecordDao.php";
require_once "model/logic/FaceControl.php";
require_once "model/logic/OrderVerifyer.php";
require_once "model/logic/URIResolver.php";

$uriRes = URIResolver::getURIResolver();
if ($uriRes->hasPOST('order')) {
    $dao = new CartDao();
    $address = $uriRes->getPOSTValue('address');
    $phone = $uriRes->getPOSTValue('phone');
    $cart = $dao->getAll();

    $errors_msg = array();
    $errors_msg["incorrect_address"] = "Некорректно введен адрес";
    $errors_msg["incorrect_phone"] = "Некорректный телефон";

    $verifyer = new OrderVerifyer($errors_msg);
    $error = $verifyer->orderErrors($address, $phone);

    if (!$error && isset($_SESSION["logged_user"])) {
        $login = $_SESSION["logged_user"];
        $userDao = new UserDao($mysqli);
        $user = $userDao->getBy('login', $login)[0];
        $orderDao = new OrderRecordDao($mysqli);
        foreach ($cart as $record) {
            $product = $record->getProduct();
            $count = $record->getCount();
            $orderDao->add(new OrderRecord(0, $user, $product,
                $count, $address, $phone, date("Y-m-d")));
            $dao->delete($record);
        }
        gotoPage("http://localhost:63342/courseproject/index.php");
    } else if (!$error) {
        $orderDao = new OrderRecordDao($mysqli);
        foreach ($cart as $record) {
            $product = $record->getProduct();
            $count = $record->getCount();
            $orderDao->add(new OrderRecord(0, null, $product,
                $count, $address, $phone, date("Y-m-d")));
            $dao->delete($record);
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
        <title>Заказ</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <form action="" method="POST" class="user_identify">
            <h2>Оформление заказа</h2>
            <p>Адрес<br><input type="text" name="address"></p>
            <p>Телефон<br><input type="text" name="phone"></p>
            <button type="submit" name="order">Отправить</button>
        </form>
    </body>

</html>