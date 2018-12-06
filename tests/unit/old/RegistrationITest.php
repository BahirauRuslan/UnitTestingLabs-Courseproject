<?php

require_once __DIR__ . '\..\..\model\logic\RegistrationVerifyer.php';
require_once __DIR__ . '\..\..\model\logic\Registrator.php';

class RegistrationITest extends \Codeception\Test\Unit
{
    protected $errors_msg;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_login"] = "Некорректно введен логин";
        $this->errors_msg["incorrect_password"] = "Некорректно введен пароль";
        $this->errors_msg["incorrect_email"] = "Некорректно введен email";
        $this->errors_msg["double_login"] = "Данный логин уже занят";
        $this->errors_msg["double_email"] = "Пользователь с данной почтой уже существует";
        $this->errors_msg["incorrect_repeat"] = "Неверно подтвержден пароль";
    }

    public function testRegistrationErrorsWithoutErrors()
    {
        $login = "testlogin";
        $email = "for.test@email.ooo";
        $password = "1t2e3s4t";
        $password2 = $password;
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class,
            ['query' => \Codeception\Stub\Expected::exactly(3, $res)]);
        $error = (new RegistrationVerifyer($this->errors_msg))->registrationErrors($login,
            $email, $password, $password2, $db);
        $this->assertFalse($error);
        (new Registrator())->registrateUser($login, $email, $password, $error, $db);
    }

    public function testRegistrationErrorsWithIncorrectLogin()
    {
        $login = "tesЛogin";
        $email = "for.test@email.ooo";
        $password = "1t2e3s4t";
        $password2 = $password;
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class,
            ['query' => \Codeception\Stub\Expected::never($res)]);
        $error = (new RegistrationVerifyer($this->errors_msg))->registrationErrors($login,
            $email, $password, $password2, $db);
        $this->assertEquals($this->errors_msg["incorrect_login"], $error);
        (new Registrator())->registrateUser($login, $email, $password, $error, $db);
    }

    public function testRegistrationErrorsWithIncorrectPassword()
    {
        $login = "teslogin";
        $email = "for.test@email.ooo";
        $password = "pw";
        $password2 = $password;
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class,
            ['query' => \Codeception\Stub\Expected::never($res)]);
        $error = (new RegistrationVerifyer($this->errors_msg))->registrationErrors($login,
            $email, $password, $password2, $db);
        $this->assertEquals($this->errors_msg["incorrect_password"], $error);
        (new Registrator())->registrateUser($login, $email, $password, $error, $db);
    }

    public function testRegistrationErrorsWithIncorrectEmail()
    {
        $login = "teslogin";
        $email = "so back";
        $password = "1t2e3s4t";
        $password2 = $password;
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class,
            ['query' => \Codeception\Stub\Expected::never($res)]);
        $error = (new RegistrationVerifyer($this->errors_msg))->registrationErrors($login,
            $email, $password, $password2, $db);
        $this->assertEquals($this->errors_msg["incorrect_email"], $error);
        (new Registrator())->registrateUser($login, $email, $password, $error, $db);
    }

    public function testRegistrationErrorsWithIncorrectPasswordRepeat()
    {
        $login = "teslogin";
        $email = "for.test@email.ooo";
        $password = "1t2e3s4t";
        $password2 = "1t2e354t";
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class,
            ['query' => \Codeception\Stub\Expected::exactly(2, $res)]);
        $error = (new RegistrationVerifyer($this->errors_msg))->registrationErrors($login,
            $email, $password, $password2, $db);
        $this->assertEquals($this->errors_msg["incorrect_repeat"], $error);
        (new Registrator())->registrateUser($login, $email, $password, $error, $db);
    }

    public function testRegistrationErrorsLoginExist()
    {
        $login = "teslogin";
        $email = "for.test@email.ooo";
        $password = "1t2e3s4t";
        $password2 = "1t2e3s4t";
        $regver = $this->construct(RegistrationVerifyer::class, [$this->errors_msg],
            ["isExistUser" => true]);
        $error = $regver->registrationErrors($login,
            $email, $password, $password2, null);
        $this->assertEquals($this->errors_msg["double_login"], $error);
        (new Registrator())->registrateUser($login, $email, $password, $error, null);
    }

    public function testRegistrationErrorsEmailExist()
    {
        $login = "teslogin";
        $email = "for.test@email.ooo";
        $password = "1t2e3s4t";
        $password2 = "1t2e3s4t";
        $regver = $this->construct(RegistrationVerifyer::class, [$this->errors_msg],
            ["isExistUser" => false, "isExistEmail" => true]);
        $error = $regver->registrationErrors($login,
            $email, $password, $password2, null);
        $this->assertEquals($this->errors_msg["double_email"], $error);
        (new Registrator())->registrateUser($login, $email, $password, $error, null);
    }
}
