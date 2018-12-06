<?php

require_once __DIR__ . '\..\util\dao\UserDao.php';

class Registrator
{
    public function registrateUser($login, $email, $password, $errors, $db)
    {
        if (!$errors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $dao = new UserDao($db);
            $dao->add(new User(0, $login, $email, $hash));
        }
    }
}