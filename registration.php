<?php
require_once "model/util/session.php";
require_once "model/util/connectDB.php";
require_once "model/util/utilFunc.php";
require_once "model/logic/RegistrationVerifyer.php";
require_once "model/util/dao/UserDao.php";

if (isset($_POST["do_registration"])) {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $errors_msg = array();
    $errors_msg["incorrect_login"] = "Некорректно введен логин";
    $errors_msg["incorrect_password"] = "Некорректно введен пароль";
    $errors_msg["incorrect_email"] = "Некорректно введен email";
    $errors_msg["double_login"] = "Данный логин уже занят";
    $errors_msg["double_email"] = "Пользователь с данной почтой уже существует";
    $errors_msg["incorrect_repeat"] = "Неверно подтвержден пароль";


    $verifyer = new RegistrationVerifyer($errors_msg);
    $error = $verifyer->registrationErrors($login, $email, $password,
        $password2, $mysqli);
    
    if (!$error) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $dao = new UserDao($mysqli);
        $dao->add(new User(0, $login, $email, $hash));
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
        <title>Регистрация</title>
        <link rel="shortcut icon" href="view/pictures/main.ico" type="image/x-icon">
        <link href="view/css/style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <form action="" method="POST" class="user_identify">
            <h2>Регистрация</h2>
            <p>Логин<br><input type="text" name="login" autocomplete="off"></p>
            <p>Почта<br><input type="text" name="email" autocomplete="off"></p>
            <p>Пароль<br><input type="password" name="password"></p>
            <p>Подтверждение пароля<br><input type="password" name="password2"></p>
            <button type="submit" name="do_registration">Зарегистрироваться</button>
        </form>
    </body>

</html>
