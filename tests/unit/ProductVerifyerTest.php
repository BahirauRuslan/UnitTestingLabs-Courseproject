<?php

require_once __DIR__ . '\..\..\model\logic\ProductVerifyer.php';

class ProductVerifyerTest extends \Codeception\Test\Unit
{
    private $errors_msg;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_name"] = "1";
        $this->errors_msg["incorrect_price"] = "2";
        $this->errors_msg["big_description"] = "3";
        $this->errors_msg["double_name"] = "4";
    }

    public function testProductErrorsIncorrectNameExpectMessage()
    {
        $name = "a";
        $price = 23;
        $description = "good good";
        $verifyer = new ProductVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_name"];
        $actual = $verifyer->productErrors($name, $price, $description, null);
        $this->assertEquals($expected, $actual);
    }

    public function testProductErrorsIncorrectPriceExpectMessage()
    {
        $name = "intel core i3";
        $price = -23;
        $description = "good good";
        $verifyer = new ProductVerifyer($this->errors_msg);
        $expected = $this->errors_msg["incorrect_price"];
        $actual = $verifyer->productErrors($name, $price, $description, null);
        $this->assertEquals($expected, $actual);
    }

    public function testProductErrorsIncorrectDescriptionExpectMessage()
    {
        $name = "intel core i3";
        $price = 23;
        $description = "";
        $verifyer = $this->construct(ProductVerifyer::class,
            [$this->errors_msg], ["isCorrectDescription" => false]);
        $expected = $this->errors_msg["big_description"];
        $actual = $verifyer->productErrors($name, $price, $description, null);
        $this->assertEquals($expected, $actual);
    }

    public function testProductErrorsExistNameExpectMessage()
    {
        $name = "intel core i3";
        $price = 23;
        $description = "lalala";
        $verifyer = $this->construct(ProductVerifyer::class,
            [$this->errors_msg], ["isExistName" => true]);
        $expected = $this->errors_msg["double_name"];
        $actual = $verifyer->productErrors($name, $price, $description, null);
        $this->assertEquals($expected, $actual);
    }

    public function testProductErrorsCorrectProductExpectFalse()
    {
        $name = "intel core i3";
        $price = 23;
        $description = "lalala";
        $verifyer = $this->construct(ProductVerifyer::class,
            [$this->errors_msg], ["isExistName" => false]);
        $actual = $verifyer->productErrors($name, $price, $description, null);
        $this->assertFalse($actual);
    }
}
