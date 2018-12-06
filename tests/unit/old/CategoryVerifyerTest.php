<?php

require_once __DIR__ . '\..\..\model\logic\CategoryVerifyer.php';

class CategoryVerifyerTest extends \Codeception\Test\Unit
{
    private $verifyer;
    protected $tester;
    
    protected function _before()
    {
        $errors_msg = array();
        $errors_msg["incorrect_name"] = "1";
        $errors_msg["double_name"] = "2";
        $this->verifyer = new CategoryVerifyer($errors_msg);
    }

    protected function _after()
    {
    }

    public function testCategoryErrorsIncorrectNameMessageOne()
    {
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class, ['query' => $res]);
        $name = "V";
        $this->assertEquals("1", $this->verifyer->categoryErrors($name, $db));
    }

    public function testCategoryErrorsExistNameMessageTwo()
    {
        $errors_msg = array();
        $errors_msg["incorrect_name"] = "1";
        $errors_msg["double_name"] = "2";
        $verifyer = $this->construct(CategoryVerifyer::class, [$errors_msg],
            ['isExistCategoryName' => true]);
        $name = "VR";
        $this->assertEquals("2", $verifyer->categoryErrors($name, null));
    }

    public function testCategoryErrorsValidNameFalse()
    {
        $name = "VR";
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class, ['query' => $res]);
        $this->assertFalse($this->verifyer->categoryErrors($name, $db));
    }

    public function testIsExistCategoryNameUniqueNameFalse()
    {
        $name = "VR";
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class, ['query' => $res]);
        $this->assertFalse($this->verifyer->isExistCategoryName($name, $db));
    }

    public function testIsCorrectNameShortNameFalse()
    {
        $name = "I";
        $this->assertFalse($this->verifyer->isCorrectName($name));
    }
}