<?php

require_once __DIR__ . '\..\util\dao\UserDao.php';

class RegistrationVerifyer
{
    private $error_msgs = array();

    public function __construct(array $error_msgs)
    {
        $this->error_msgs = $error_msgs;
    }

    public function registrationErrors($login, $email, $password, $password2, $mysqli) {
        if (!self::isCorrectLogin($login)) {
            return $this->error_msgs["incorrect_login"];
        } else if (!$this->isCorrectPassword($password)) {
            return $this->error_msgs["incorrect_password"];
        } else if (!$this->isCorrectEmail($email)) {
            return $this->error_msgs["incorrect_email"];
        } else if ($this->isExistUser($login, $mysqli)) {
            return $this->error_msgs["double_login"];
        } else if ($this->isExistEmail($email, $mysqli)) {
            return $this->error_msgs["double_email"];
        } else if ($password != $password2) {
            return $this->error_msgs["incorrect_repeat"];
        } else {
            return false;
        }
    }

    public function isExistUser($login, $mysqli) {
        $userDao = new UserDao($mysqli);
        $users = $userDao->getBy('login', $login);
        return count($users) != 0;
    }

    public function isExistEmail($email, $mysqli) {
        $userDao = new UserDao($mysqli);
        $users = $userDao->getBy('email', $email);
        return count($users) != 0;
    }

    public function isCorrectLogin($login) {
        return self::isSameFormat('/^[a-z0-9_-]{5,64}$/', $login);
    }

    public function isCorrectPassword($password) {
        return (strlen($password) >= 5) && (strlen($password) <= 32);
    }

    public function isCorrectEmail($email) {
        return self::isSameFormat('/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/',
                $email) && strlen($email) <= 128;
    }

    public function isSameFormat($regexp, $string) {
        return (bool) preg_match($regexp, $string);
    }
}