<?php

require_once __DIR__ . '\..\util\dao\ProductDao.php';

class ProductVerifyer
{

    private $error_msgs = array();

    public function __construct(array $error_msgs)
    {
        $this->error_msgs = $error_msgs;
    }

    public function productErrors($name, $price, $description, $mysqli) {
        if (!$this->isCorrectName($name)) {
            return $this->error_msgs["incorrect_name"];
        } else if (!$this->isCorrectPrice($price)) {
            return $this->error_msgs["incorrect_price"];
        } else if (!$this->isCorrectDescription($description)) {
            return $this->error_msgs["big_description"];
        } else if ($this->isExistName($name, $mysqli)) {
            return $this->error_msgs["double_name"];
        } else {
            return false;
        }
    }

    public function isExistName($name, $mysqli)
    {
        $dao = new ProductDao($mysqli);
        $categories = $dao->getBy('name', $name);
        return count($categories) != 0;
    }

    public function isCorrectName($name)
    {
        return strlen($name) >= 5 && strlen($name) <= 128;
    }

    public function isCorrectPrice($price)
    {
        return $price >= 0 && $price <= 2147483648;
    }

    public function isCorrectDescription($description)
    {
        return strlen($description) <= 10000;
    }
}