<?php

require_once __DIR__ . '\..\..\model\logic\AuthenticationVerifyer.php';
require_once __DIR__ . '\..\..\model\logic\Authenticator.php';
require_once __DIR__ . '\..\..\model\logic\FaceControl.php';

class AuthenticationITest extends \Codeception\Test\Unit
{
    protected $errors_msg;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_login"] = "Некорректно введен логин";
        $this->errors_msg["incorrect_password"] = "Некорректно введен пароль";
        $this->errors_msg["not_user"] = "Неправильный логин или пароль";
        $_SESSION = array();
    }

    public function testAuthenticationErrorsAdmin()
    {
        $login = "admin";
        $password = "admin";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isExistUser" => true, "isTrueUser" => true]);
        $error = $verifyer->authenticationErrors($login, $password, null);
        $this->assertFalse($error);
        (new Authenticator())->authenticate($login, $error);
        $this->assertTrue(FaceControl::getFaceControl()->isAdmin());
    }

    public function testAuthenticationErrorsExistUser()
    {
        $login = "login";
        $password = "password";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isExistUser" => true, "isTrueUser" => true]);
        $error = $verifyer->authenticationErrors($login, $password, null);
        $this->assertFalse($error);
        (new Authenticator())->authenticate($login, $error);
        $this->assertEquals($login,
            FaceControl::getFaceControl()->getOneOf(null, $login));
    }

    public function testAuthenticationErrorsExistUserButPasswordNotValid()
    {
        $login = "login";
        $password = "password";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isExistUser" => true, "isTrueUser" => false]);
        $error = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($this->errors_msg["not_user"], $error);
        (new Authenticator())->authenticate($login, $error);
        $this->assertEquals($login,
            FaceControl::getFaceControl()->getOneOf($login, null));
    }

    public function testAuthenticationErrorsNotExistUser()
    {
        $login = "login";
        $password = "password";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isExistUser" => false, "isTrueUser" => false]);
        $error = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($this->errors_msg["not_user"], $error);
        (new Authenticator())->authenticate($login, $error);
        $this->assertEquals($login,
            FaceControl::getFaceControl()->getOneOf($login, null));
    }

    public function testAuthenticationErrorsIncorrectPassword()
    {
        $login = "login";
        $password = "pw";
        $verifyer = new AuthenticationVerifyer($this->errors_msg);
        $error = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($this->errors_msg["incorrect_password"], $error);
        (new Authenticator())->authenticate($login, $error);
        $this->assertEquals($login,
            FaceControl::getFaceControl()->getOneOf($login, null));
    }

    public function testAuthenticationErrorsIncorrectLogin()
    {
        $login = "Логин";
        $password = "password";
        $verifyer = new AuthenticationVerifyer($this->errors_msg);
        $error = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($this->errors_msg["incorrect_login"], $error);
        (new Authenticator())->authenticate($login, $error);
        $this->assertEquals($login,
            FaceControl::getFaceControl()->getOneOf($login, null));
    }
}
