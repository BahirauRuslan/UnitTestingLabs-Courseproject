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

    public function testCategoryErrorsIncorrectNameMessageOne()
    {
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class, ['query' => $res]);
        $name = "V";
        $expected = "1";
        $actual = $this->verifyer->categoryErrors($name, $db);
        $this->assertEquals($expected, $actual);
    }

    public function testCategoryErrorsExistNameMessageTwo()
    {
        $errors_msg = array();
        $errors_msg["incorrect_name"] = "1";
        $errors_msg["double_name"] = "2";
        $verifyer = $this->construct(CategoryVerifyer::class, [$errors_msg],
            ['isExistCategoryName' => true]);
        $name = "VR";
        $expected = "2";
        $actual =  $verifyer->categoryErrors($name, null);
        $this->assertEquals($expected, $actual);
    }

    public function testCategoryErrorsValidNameFalse()
    {
        $name = "VR";
        $res = $this->make(mysqli_result::class, ['fetch_assoc' => false]);
        $db = $this->make(mysqli::class, ['query' => $res]);
        $actual = $this->verifyer->categoryErrors($name, $db);
        $this->assertFalse($actual);
    }
}
