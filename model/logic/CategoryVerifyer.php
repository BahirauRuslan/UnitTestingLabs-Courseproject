<?php

require_once __DIR__ . '\..\util\dao\CategoryDao.php';

class CategoryVerifyer
{

    private $error_msgs = array();

    public function __construct(array $error_msgs)
    {
        $this->error_msgs = $error_msgs;
    }

    public function categoryErrors($name, $mysqli) {
        if (!$this->isCorrectName($name)) {
            return $this->error_msgs["incorrect_name"];
        } else if ($this->isExistCategoryName($name, $mysqli)) {
            return $this->error_msgs["double_name"];
        } else {
            return false;
        }
    }

    public function isExistCategoryName($name, $mysqli)
    {
        $dao = new CategoryDao($mysqli);
        $categories = $dao->getBy('name', $name);
        return count($categories) != 0;
    }

    public function isCorrectName($name)
    {
        return strlen($name) >= 2 && strlen($name) <= 64;
    }
}
