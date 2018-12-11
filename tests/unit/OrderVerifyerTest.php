<?php

require_once __DIR__ . '\..\..\model\logic\OrderVerifyer.php';

class OrderVerifyerTest extends \Codeception\Test\Unit
{
    private $errors_msg;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_address"] = "Некорректный адрес";
        $this->errors_msg["incorrect_phone"] = "Некорректный телефон";
    }

    public function testOrderErrorsIncorrectAddressExpectMessage()
    {
        $address = "Htlr";
        $phone = "1234567";
        $verifyer = new OrderVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_address"];
        $actual = $verifyer->orderErrors($address, $phone);
        $this->assertEquals($expected, $actual);
    }

    public function testOrderErrorsIncorrectPhoneExpectMessage()
    {
        $address = "Htlr street";
        $phone = "1234";
        $verifyer = new OrderVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_phone"];
        $actual = $verifyer->orderErrors($address, $phone);
        $this->assertEquals($expected, $actual);
    }

    public function testOrderErrorsCorrectOrderExpectFalse()
    {
        $address = "Htlr street";
        $phone = "1234567";
        $verifyer = new OrderVerifyer($this->errors_msg);
        $actual = $verifyer->orderErrors($address, $phone);
        $this->assertFalse($actual);
    }
}
