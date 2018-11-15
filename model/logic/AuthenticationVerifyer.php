<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\UserDao.php";

class AuthenticationVerifyer
{
    private $error_msgs = array();

    public function __construct(array $error_msgs)
    {
        $this->error_msgs = $error_msgs;
    }

    public function authenticationErrors($login, $password, $mysqli) {
        if (!$this->isCorrectLogin($login)) {
            return $this->error_msgs['incorrect_login'];
        } else if (!$this->isCorrectPassword($password)) {
            return $this->error_msgs['incorrect_password'];
        } else if (!$this->isTrueUser($login, $password, $mysqli)) {
            return $this->error_msgs['not_user'];
        } else {
            return false;
        }
    }

    public function isTrueUser($login, $password, $mysqli) {
        if ($this->isExistUser($login, $mysqli)) {
            $dao = new UserDao($mysqli);
            $user = $dao->getBy('login', $login)[0];
            $hash = $user->getPassword();
            return password_verify($password, $hash);
        }
        return false;
    }

    public function isExistUser($login, $mysqli) {
        $userDao = new UserDao($mysqli);
        $users = $userDao->getBy('login', $login);
        return count($users) != 0;
    }

    public function isCorrectLogin($login) {
        return $this->isSameFormat('/^[a-z0-9_-]{5,64}$/', $login);
    }

    public function isCorrectPassword($password) {
        return (strlen($password) >= 5) && (strlen($password) <= 32);
    }

    public function isSameFormat($regexp, $string) {
        return (bool) preg_match($regexp, $string);
    }
}