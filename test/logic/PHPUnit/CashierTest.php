<?php

require_once __DIR__ . '\..\..\..\model\logic\Cashier.php';

class CashierTest extends PHPUnit_Framework_TestCase
{
    public function testGetTotalPriceCartNotArrayInvalidArgumentException()
    {
        self::expectException(InvalidArgumentException::class);
        $cashier = Cashier::getCashier();
        $cart = 2;
        $cashier->getTotalPrice($cart);
    }

    public function testGetTotalPriceCartEmptyArrayZero()
    {
        $cashier = Cashier::getCashier();
        $cart = array();
        $expected = 0;
        $actual = $cashier->getTotalPrice($cart);
        self::assertEquals($expected, $actual);
    }

    public function testGetTotalPriceCartArrayWithoutCartRecordsZero()
    {
        $cashier = Cashier::getCashier();
        $cart = array("lalala", 34);
        $expected = 0;
        $actual = $cashier->getTotalPrice($cart);
        self::assertEquals($expected, $actual);
    }

    public function testGetTotalPriceCartArrayWithFiveProductsPriceThirteenResultSixtyFive()
    {
        $cashier = Cashier::getCashier();
        $cart = array(new CartRecord
        (new Product(12, "i5 3570", new Category(11, "CPU"),
            13, "3-th gen"), 5));
        $expected = 65;
        $actual = $cashier->getTotalPrice($cart);
        self::assertEquals($expected, $actual);
    }
}
