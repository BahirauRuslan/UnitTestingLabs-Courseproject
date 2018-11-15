<?php

class OrderVerifyer
{

    private $error_msgs = array();

    public function __construct(array $error_msgs)
    {
        $this->error_msgs = $error_msgs;
    }

    public function orderErrors($address, $phone) {
        if (!$this->isCorrectAddress($address)) {
            return $this->error_msgs["incorrect_address"];
        } else if (!$this->isCorrectPhone($phone)) {
            return $this->error_msgs["incorrect_phone"];
        } else {
            return false;
        }
    }

    public function isCorrectAddress($name)
    {
        return strlen($name) >= 7 && strlen($name) <= 100;
    }

    public function isCorrectPhone($phone)
    {
        return strlen($phone) == 7 && is_numeric($phone);
    }

    public function isCorrectCount($count)
    {
        return is_numeric($count) && $count >= 1 && $count <= 256;
    }
}