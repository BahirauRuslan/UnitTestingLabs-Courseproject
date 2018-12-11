<?php

require_once __DIR__ . '\..\..\model\logic\ProductVerifyer.php';

class ProductVerifyerTest extends \Codeception\Test\Unit
{
    private $errors_msg;

    protected function _before()
    {
        $this->errors_msg = array();
        $this->errors_msg["incorrect_address"] = "Некорректный адрес";
        $this->errors_msg["incorrect_phone"] = "Некорректный телефон";
    }
}
