<?php

require_once __DIR__ . '\..\..\model\logic\RegistrationVerifyer.php';

class RegistrationVerifyerTest extends \Codeception\Test\Unit
{
    private $errors_msg;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_login"] = "1";
        $this->errors_msg["incorrect_password"] = "2";
        $this->errors_msg["incorrect_email"] = "3";
        $this->errors_msg["double_login"] = "4";
        $this->errors_msg["double_email"] = "5";
        $this->errors_msg["incorrect_repeat"] = "6";
    }

    public function testRegistrationErrorsIncorrectLoginExpectMessage()
    {
        $login = "la";
        $password = "123456789";
        $email = "lalala@lala.la";
        $password2 = $password;
        $verifyer = new RegistrationVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_login"];
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertEquals($expected, $actual);
    }

    public function testRegistrationErrorsIncorrectPasswordExpectMessage()
    {
        $login = "lalalalal";
        $password = "12";
        $email = "lalala@lala.la";
        $password2 = $password;
        $verifyer = new RegistrationVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_password"];
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertEquals($expected, $actual);
    }

    public function testRegistrationErrorsIncorrectEmailExpectMessage()
    {
        $login = "lalalalal";
        $password = "123456789";
        $email = "lalalalala.la";
        $password2 = $password;
        $verifyer = new RegistrationVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_email"];
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertEquals($expected, $actual);
    }

    public function testRegistrationErrorsExistLoginExpectMessage()
    {
        $login = "lalalalal";
        $password = "123456789";
        $email = "lalala@lala.la";
        $password2 = $password;
        $verifyer = $this->construct(RegistrationVerifyer::class,
            [$this->errors_msg], ["isExistUser" => true]);
        $expected = $this->errors_msg["double_login"];
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertEquals($expected, $actual);
    }

    public function testRegistrationErrorsExistEmailExpectMessage()
    {
        $login = "lalalalal";
        $password = "123456789";
        $email = "lalala@lala.la";
        $password2 = $password;
        $verifyer = $this->construct(RegistrationVerifyer::class,
            [$this->errors_msg], ["isExistEmail" => true, "isExistUser" => false]);
        $expected = $this->errors_msg["double_email"];
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertEquals($expected, $actual);
    }

    public function testRegistrationErrorsIncorrectRepeatExpectMessage()
    {
        $login = "lalalalal";
        $password = "123456789";
        $email = "lalala@lala.la";
        $password2 = "12345789";
        $verifyer = $this->construct(RegistrationVerifyer::class,
            [$this->errors_msg], ["isExistEmail" => false, "isExistUser" => false]);
        $expected = $this->errors_msg["incorrect_repeat"];
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertEquals($expected, $actual);
    }

    public function testRegistrationErrorsCorrectUserExpectFalse()
    {
        $login = "lalalalal";
        $password = "123456789";
        $email = "lalala@lala.la";
        $password2 = $password;
        $verifyer = $this->construct(RegistrationVerifyer::class,
            [$this->errors_msg], ["isExistEmail" => false, "isExistUser" => false]);
        $actual = $verifyer->registrationErrors($login, $email,
            $password, $password2, null);
        $this->assertFalse($actual);
    }
}
