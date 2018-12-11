<?php

require_once __DIR__ . '\..\..\model\logic\Authenticator.php';

class AuthenticatorTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        $_SESSION = array();
    }

    public function testAuthenticateWithErrorExpectNoActin()
    {
        $login = "login";
        $error = true;
        $authenticator = new Authenticator();
        $expected = $_SESSION;
        $authenticator->authenticate($login, $error);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }

    public function testAuthenticateWithoutErrorExpectAuthenticate()
    {
        $login = "login";
        $error = false;
        $authenticator = new Authenticator();
        $expected = array("logged_user" => "login");
        $authenticator->authenticate($login, $error);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }
}
