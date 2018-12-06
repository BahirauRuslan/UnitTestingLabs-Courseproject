<?php

class Authenticator
{
    public function authenticate($login, $error)
    {
        if (!$error) {
            $_SESSION["logged_user"] = $login;
        }
    }
}