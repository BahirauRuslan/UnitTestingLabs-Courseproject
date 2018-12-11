<?php

require_once __DIR__ . '\..\..\model\logic\Registrator.php';

class RegistratorTest extends \Codeception\Test\Unit
{
    public function testRegistrateUserWithErrorExpectNoAction()
    {
        $mysqliMock = $this->make(mysqli::class,
            ["query" => \Codeception\Stub\Expected::never()]);
        $login = "lalalal";
        $email = "lalalal@lalala.la";
        $password = "12345678";
        $registrator = new Registrator();
        $registrator->registrateUser($login, $email, $password, true, $mysqliMock);
    }

    public function testRegistrateUserWithoutErrorExpectAction()
    {
        $mysqliMock = $this->make(mysqli::class,
            ["query" => \Codeception\Stub\Expected::once()]);
        $login = "lalalal";
        $email = "lalalal@lalala.la";
        $password = "12345678";
        $registrator = new Registrator();
        $registrator->registrateUser($login, $email, $password, false, $mysqliMock);
    }
}
