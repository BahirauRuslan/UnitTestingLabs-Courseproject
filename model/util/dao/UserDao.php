<?php

require_once "IdentificationalDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\User.php";

class UserDao extends IdentificationalDao
{
    public function __construct($db)
    {
        parent::__construct($db, 'users');
    }

    protected function convert($rec)
    {
        return new User($rec['id'], $rec['login'], $rec['email'], $rec['password']);
    }

    public function add($record)
    {
        if ($record instanceof User)
        {
            $login = $record->getLogin();
            $email = $record->getEmail();
            $password = $record->getPassword();
            $table_name = $this->getTableName();
            $this->getDb()->query("INSERT INTO `$table_name` (`login`, `email`, `password`) 
                VALUES ('$login', '$email', '$password')");
        }
        else
        {
            throw new InvalidArgumentException("user");
        }
    }

    public function update($record)
    {
        if ($record instanceof User)
        {
            $id = $record->getId();
            $login = $record->getLogin();
            $email = $record->getEmail();
            $password = $record->getPassword();
            $table_name = $this->getTableName();
            $this->getDb()->query("UPDATE `$table_name` SET `login` = '$login', `email` = '$email',
                      `password` = '$password' WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("user");
        }
    }
}
