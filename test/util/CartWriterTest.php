<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\CartWriter.php";

class CartWriterTest extends PHPUnit_Framework_TestCase
{

    public function testWriteNotArrayInvalidArgumentException()
    {
        self::expectException(InvalidArgumentException::class);
        $writer = new CartWriter();
        $record = 23;
        $writer->write($record);
    }

    public function testWriteEmptyArrayFalse()
    {
        $writer = new CartWriter();
        $record = array();
        $writer->write($record);
        $expected = 0;
        $actual = count($_COOKIE);
        self::assertEquals($expected, $actual);
    }

    public function testWriteArrayWithoutCartRecordFalse()
    {
        $writer = new CartWriter();
        $record = array(12, "adfsd");
        $writer->write($record);
        $expected = 0;
        $actual = count($_COOKIE);
        self::assertEquals($expected, $actual);
    }

    public function testWriteCartRecordsFive()
    {
        $writer = new CartWriter();
        $cartRec = new CartRecord
        (new Product(12, "i5 3570", new Category(11, "CPU"),
            13, "3-th gen"), 5);
        $record = array($cartRec);
        $writer->write($record);
        $expected = 5;
        $actual = $_SESSION["product_id:12"];
        self::assertEquals($expected, $actual);
    }
}
