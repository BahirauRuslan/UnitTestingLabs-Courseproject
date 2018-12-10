<?php

require_once __DIR__ . '\..\..\model\util\dao\CartDao.php';

class CartDaoTest extends \Codeception\Test\Unit
{
    private $cartDao;

    protected function setUp()
    {
        $this->cartDao = new CartDao();
        $_SESSION = array();
    }

    public function testAddNotArrayExpectInvalidArgumentException()
    {
        $notArray = "test";
        $this->expectException(InvalidArgumentException::class);
        $this->cartDao->add($notArray);
    }

    public function testAddEmptyArrayExpectEmptySession()
    {
        $emptyArray = array();
        $expected = 0;
        $this->cartDao->add($emptyArray);
        $actual = count($_SESSION);
        $this->assertEquals($expected, $actual);
    }

    public function testAddArrayWithoutCartRecordsExpectEmptySession()
    {
        $arrayWithoutCartRecords = array(225, "test", 1.337);
        $expected = 0;
        $this->cartDao->add($arrayWithoutCartRecords);
        $actual = count($_SESSION);
        $this->assertEquals($expected, $actual);
    }

    public function testAddArrayWithCartRecordsExpectCartRecordSessions()
    {
        $cart = array();
        $product1_id = 12;
        $product2_id = 16;
        $product1_count = 5;
        $product2_count = 2;
        $cart[] = new CartRecord(new Product($product1_id, "i5 3570",
            new Category(11, "CPU"), 13, "3-th gen"), $product1_count);
        $cart[] = new CartRecord(new Product($product2_id, "8 x 2 GB Fury",
            new Category(51, "RAM"), 10, "fury"), $product2_count);
        $expected = array("product_id:" . $product1_id => $product1_count,
            "product_id:" . $product2_id => $product2_count);
        $this->cartDao->add($cart);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }

    public function testDeleteNotCartRecordExpectNoChanges()
    {
        $_SESSION = array("product_id:23" => 12,
            "product_id:14" => 11);
        $notCartRecord = "test";
        $expected = $_SESSION;
        $this->cartDao->delete($notCartRecord);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }

    public function testDeleteCartRecordExpectSessionWithoutThisCartRecord()
    {
        $product_id = 23;
        $product_count = 12;
        $_SESSION = array("product_id:" . $product_id => $product_count,
            "product_id:14" => 11);
        $cartRecord =  new CartRecord(new Product($product_id, "i5 3570",
            new Category(11, "CPU"), 13, "3-th gen"), $product_count);
        $expected = array("product_id:14" => 11);
        $this->cartDao->delete($cartRecord);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }

    public function testDeleteByIdRecordNotExistExpectNoChanges()
    {
        $_SESSION = array("product_id:12" => 12, "product_id:17" => 2);
        $notExistId = 19;
        $expected = $_SESSION;
        $this->cartDao->deleteById($notExistId);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }

    public function testDeleteByIdCartRecordIdExpectSessionWithoutThisCartRecord()
    {
        $id = 12;
        $_SESSION = array("product_id:" . $id => 4, "product_id:17" => 2);
        $expected = array("product_id:17" => 2);
        $this->cartDao->deleteById($id);
        $actual = $_SESSION;
        $this->assertEquals($expected, $actual);
    }
}
