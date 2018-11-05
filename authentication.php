<?php
include "scripts/connectDB.php";
include "scripts/goToPage.php";
include "model/verifyer.php";

if (isset($_POST['do_login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $error = Verifyer::getVerifyer()->authenticationErrors($login, $password, $mysqli);
    if (!$error) {
        $_SESSION['logged_user'] = $_POST['login'];
        $page = $_SESSION['logged_user'] == 'admin'
            ? "http://localhost:63342/pekar.by/admin.php"
            : "http://localhost:63342/pekar.by/index.php";
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
            <p>Логин: <input type="text" name="login"></p>
            <p>Пароль: <input type="password" name="password"></p>
            <button type="submit" name="do_login">Войти</button>
        </form>
    </body>
</html>
