<?php

require_once __DIR__ . '\..\..\model\logic\AuthenticationVerifyer.php';

class AuthenticationVerifyerTest extends \Codeception\Test\Unit
{
    private $errors_msg;
    private $iterate;
    private $user;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_login"] = "Некорректно введен логин";
        $this->errors_msg["incorrect_password"] = "Некорректно введен пароль";
        $this->errors_msg["not_user"] = "Неправильный логин или пароль";
    }

    public function testAuthenticationErrorsIncorrectLoginExpectMessage()
    {
        $login = "ы";
        $password = "124345665";
        $verifyer = new AuthenticationVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_login"];
        $actual = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($expected, $actual);
    }

    public function testAuthenticationErrorsIncorrectPasswordExpectMessage()
    {
        $login = "truelogin";
        $password = "12";
        $verifyer = new AuthenticationVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_password"];
        $actual = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($expected, $actual);
    }

    public function testAuthenticationErrorsNotExistUserExpectMessage()
    {
        $login = "truelogin";
        $password = "12123425";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isTrueUser" => false]);
        $expected = $this->errors_msg["not_user"];
        $actual = $verifyer->authenticationErrors($login, $password, null);
        $this->assertEquals($expected, $actual);
    }

    public function testAuthenticationErrorsExistUserExpectFalse()
    {
        $login = "truelogin";
        $password = "12123425";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isTrueUser" => true]);
        $actual = $verifyer->authenticationErrors($login, $password, null);
        $this->assertFalse($actual);
    }

    public function testIsTrueUserUserNotExistExpectFalse()
    {
        $login = "truelogin";
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg], ["isExistUser" => false]);
        $actual = $verifyer->isTrueUser($login, "", null);
        $this->assertFalse($actual);
    }

    public function testIsTrueUserUserExistExpectTrue()
    {
        $this->iterate = 1;
        $login = "truelogin";
        $password = "12345678";
        $email = "lalala@lalala.la";
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $this->user = [ "id" => 1, "login" => $login, "email" => $email,
            "password" => $password_hash];
        $res = $this->make(mysqli_result::class, ["fetch_assoc"
        => function() {
            if ($this->iterate & 1 == 1) {
                $this->iterate++;
                return $this->user;
            }
            $this->iterate++;
            return false;
            }]);
        $mysqliStub = $this->make(mysqli::class,["query" => $res]);
        $verifyer = $this->construct(AuthenticationVerifyer::class,
            [$this->errors_msg]);
        $actual = $verifyer->isTrueUser($login, $password, $mysqliStub);
        $this->assertTrue($actual);
    }
}
