<?php

require_once __DIR__ . '\..\..\model\util\dao\UserDao.php';

class UserDaoTest extends \Codeception\Test\Unit
{
    private $expectedParam;

    private function createMysqliQuerySpy($expectedParam)
    {
        $this->expectedParam = $expectedParam;
        return $this->make(mysqli::class,
            ["query" => function($actualParam)
            { $this->assertEquals($this->expectedParam, $actualParam); }]);
    }

    public function testAddNotUserExpectInvalidArgumentException()
    {
        $dummy = $this->make(mysqli::class);
        $userDao = new UserDao($dummy);
        $notUserObject = "test";
        $this->expectException(InvalidArgumentException::class);
        $userDao->add($notUserObject);
    }

    public function testAddCategoryExpectQuery()
    {
        $login = "loginp";
        $email = "lalala@lalal.la";
        $password = "qwertytest";
        $user = new User(11, $login, $email, $password);
        $table_name = 'users';
        $query = "INSERT INTO `$table_name` (`login`, `email`, `password`) 
                VALUES ('$login', '$email', '$password')";
        $mysqliSpy = $this->createMysqliQuerySpy($query);
        $userDao = new UserDao($mysqliSpy);
        $userDao->add($user);
    }

    public function testUpdateNotUserExpectInvalidArgumentException()
    {
        $dummy = $this->make(mysqli::class);
        $userDao = new UserDao($dummy);
        $notUserObject = "test";
        $this->expectException(InvalidArgumentException::class);
        $userDao->update($notUserObject);
    }

    public function testUpdateCategoryExpectQuery()
    {
        $id = 22;
        $login = "loginp";
        $email = "lalala@lalal.la";
        $password = "qwertytest";
        $user = new User($id, $login, $email, $password);
        $table_name = 'users';
        $query = "UPDATE `$table_name` SET `login` = '$login', `email` = '$email',
                      `password` = '$password' WHERE `id` = '$id'";
        $mysqliSpy = $this->createMysqliQuerySpy($query);
        $userDao = new UserDao($mysqliSpy);
        $userDao->update($user);
    }
}
