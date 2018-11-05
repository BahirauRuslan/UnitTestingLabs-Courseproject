<?php
include "scripts/connectDB.php";
include "scripts/goToPage.php";
include "model/verifyer.php";

if (isset($_POST["do_registration"])) {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $error = Verifyer::getVerifyer()->registrationErrors($login, $email, $password, 
        $password2, $mysqli);
    
    if (!$error) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $result = Requester::getRequester()->createUserRecord($mysqli, 
            $login, $email, $hash);
        if (!$result) {
            echo "Извините, ваша запись по техническим причинам не была добавлена";
        } else {
            gotoPage("http://localhost:63342/pekar.by/index.php");
        }
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
        <form action="registration.php" method="POST" class="user_identify">
            <p>Логин<br><input type="text" name="login"></p>
            <p>Почта<br><input type="text" name="email"></p>
            <p>Пароль<br><input type="password" name="password"></p>
            <p>Подтверждение пароля<br><input type="password" name="password2"></p>
            <button type="submit" name="do_registration">Зарегистрироваться</button>
        </form>
    </body>

</html>
