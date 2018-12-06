<?php

require_once __DIR__ . '\..\..\model\util\dao\UserDao.php';

class UserDaoTest extends \Codeception\Test\Unit
{
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testAddNotUserInvalidArgumentException()
    {
        $notUser = array("i'm user)", 148);
        self::expectException(InvalidArgumentException::class);
        $db = $this->make(mysqli::class);
        $dao = new UserDao($db);
        $dao->add($notUser);
    }

    public function testWriteUserUser()
    {
        $login = "mylogin";
        $email = "mail@email.com";
        $password = "password";
        $user = new User(0, $login, $email, $password);
        $db = $this->make(mysqli::class,
            ['query' => function($param) {$this->assertEquals(
                "INSERT INTO `users` (`login`, `email`, `password`) \r\n                VALUES ('mylogin', 'mail@email.com', 'password')", $param);}]);
        $dao = new UserDao($db);
        $dao->add($user);
    }
}