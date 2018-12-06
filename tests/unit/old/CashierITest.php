<?php

require_once __DIR__ . '\..\..\model\logic\Cashier.php';

class CashierITest extends \Codeception\Test\Unit
{
    public function testGetTotalPriceCartArrayWithFiveProductsPriceThirteenResultSixtyFive()
    {
        $cashier = Cashier::getCashier();
        $product = new Product(12, "i5 3570", new Category(11, "CPU"),
            13, "3-th gen");
        $cartRec = $this->construct(CartRecord::class,
            ["product" => $product, "count" => 5],
            ["getProduct" => \Codeception\Stub\Expected::once($product),
                "getCount" => \Codeception\Stub\Expected::once(5)]);
        $cart = array($cartRec);
        $expected = 65;
        $actual = $cashier->getTotalPrice($cart);
        self::assertEquals($expected, $actual);
    }

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
}
