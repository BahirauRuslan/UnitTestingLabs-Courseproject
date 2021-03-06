<?php
require_once "model/util/session.php";
require_once "model/util/connectDB.php";
require_once "model/util/utilFunc.php";
require_once "model/logic/AuthenticationVerifyer.php";
require_once "model/logic/Authenticator.php";

if (isset($_POST['do_login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $errors_msg = array();
    $errors_msg["incorrect_login"] = "Некорректный логин";
    $errors_msg["incorrect_password"] = "Некорректный пароль";
    $errors_msg["not_user"] = "Неправильный логин или пароль";

    $verifyer = new AuthenticationVerifyer($errors_msg);
    $error = $verifyer->authenticationErrors($login, $password, $mysqli);

    if (!$error) {
        (new Authenticator())->authenticate($login, $error);
        //$_SESSION['logged_user'] = $_POST['login'];
        $page = $_SESSION['logged_user'] == 'admin'
            ? "http://localhost:63342/courseproject/admin.php"
            : "http://localhost:63342/courseproject/index.php";
        gotoPage($page);
    } else {
        echo $error . '</br>';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Авторизация</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <form action="authentication.php" method="POST" class="user_identify">
            <h2>Вход</h2>
            <p>Логин<br><input type="text" name="login" autocomplete="off"></p>
            <p>Пароль<br><input type="password" name="password"></p>
            <button type="submit" name="do_login">Войти</button>
        </form>
    </body>
</html>
