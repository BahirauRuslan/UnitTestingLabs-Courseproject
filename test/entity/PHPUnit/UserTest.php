<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\User.php";

class UserTest extends PHPUnit_Framework_TestCase
{
    public function testSetPasswordShortPasswordInvalidArgumentException()
    {
        self::expectException(InvalidArgumentException::class);
        $user = new User(11, "login", "mail@mail.com", "password");
        $password = "1q2w";
        $user->setPassword($password);
    }

    public function testSetPasswordTruePasswordPassword()
    {
        $user = new User(11, "login", "mail@mail.com", "password");
        $expected = "1q2w3e4r5t6y";
        $user->setPassword($expected);
        $actual = password_verify($expected, $user->getPassword());
        self::assertTrue($actual);
    }
}
