<?php

require_once "DBWriter.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\User.php";

class UserWriter extends DBWriter
{
    public function __construct($mysqli)
    {
        parent::__construct($mysqli);
    }

    public function write($record)
    {
        if ($record instanceof User)
        {
            $login = $record->getLogin();
            $email = $record->getEmail();
            $password = $record->getPassword();
            $this->getDb()->query("INSERT INTO `users` (`login`, `email`, `password`) 
            VALUES ('$login', '$email', '$password')");
        }
        else
        {
            throw new InvalidArgumentException("user");
        }
    }
}