<?php

require_once "Identificational.php";

class User extends Identificational
{
    private $login;
    private $email;
    private $password;

    public function __construct($id, $login, $email, $password)
    {
        parent::__construct($id);
        $this->setLogin($login);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        if (preg_match('/^[a-z0-9_-]{5,64}$/', $login))
        {
            $this->login = $login;
        }
        else
        {
            throw new InvalidArgumentException("login");
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (preg_match('/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/',
                $email) && strlen($email) <= 128)
        {
            $this->email = $email;
        }
        else
        {
            throw new InvalidArgumentException("email");
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if ((strlen($password) >= 5) && (strlen($password) <= 32))
        {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
        else
        {
            throw new InvalidArgumentException("password");
        }
    }
}
