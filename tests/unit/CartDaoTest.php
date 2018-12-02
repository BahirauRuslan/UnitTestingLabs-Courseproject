<?php

require_once __DIR__ . '\..\..\model\util\dao\CartDao.php';

class CartDaoTest extends \Codeception\Test\Unit
{
    protected $tester;
    
    protected function _before()
    {
        $_SESSION = array();
    }

    protected function _after()
    {
    }

    public function testWriteNotArrayInvalidArgumentException()
    {
        self::expectException(InvalidArgumentException::class);
        $writer = new CartDao();
        $record = 23;
        $writer->add($record);
    }

    public function testWriteEmptyArrayFalse()
    {
        $writer = new CartDao();
        $record = array();
        $writer->add($record);
        $expected = 0;
        $actual = count($_SESSION);
        self::assertEquals($expected, $actual);
    }

    public function testWriteArrayWithoutCartRecordFalse()
    {
        $writer = new CartDao();
        $record = array(12, "adfsd");
        $writer->add($record);
        $expected = 0;
        $actual = count($_SESSION);
        self::assertEquals($expected, $actual);
    }

    public function testWriteCartRecordsFive()
    {
        $writer = new CartDao();
        $cartRec = new CartRecord
        (new Product(12, "i5 3570", new Category(11, "CPU"),
            13, "3-th gen"), 5);
        $record = array($cartRec);
        $writer->add($record);
        $expected = 5;
        $actual = $_SESSION["product_id:12"];
        self::assertEquals($expected, $actual);
    }
}