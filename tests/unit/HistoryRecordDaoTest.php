<?php

require_once __DIR__ . '\..\..\model\util\dao\HistoryRecordDao.php';

class HistoryRecordDaoTest extends \Codeception\Test\Unit
{
    private $iterate;
    private $obj;
    private $queryStr;
    private $mysqliResultStub;
    private $mysqliStub;
    private $expectedParam;

    public function testAddNotHistoryRecordExpectInvalidArgumentException()
    {
        $object = "test";
        $db = $this->createMysqliQuerySpy(null);
        $dao = new HistoryRecordDao($db);
        $this->expectException(InvalidArgumentException::class);
        $dao->add($object);
    }

    public function testAddHistoryRecordExpectAction()
    {
        $user_id = 14;
        $product_id = 16;
        $count = 2;
        $address = "Htlr street, 14/oooo";
        $phone = "1234567";
        $order_date = '2018-01-01';
        $confirm_date = '2018-01-02';
        $object = new HistoryRecord(12, new User($user_id, "aaaaaaa",
            "aswer@test.se", "12345678"), new Product($product_id,
            "namename", new Category(123, "lalala"), 143,
            "lalala"), $count,
            $address, $phone, $order_date, $confirm_date);
        $db = $this->createMysqliQuerySpy("INSERT INTO `log` (`user_id`, `product_id`, `count`, `address`,
            `phone`, `order_date`, `confirm_date`) 
            VALUES ('$user_id', '$product_id', '$count', '$address', '$phone', '$order_date', '$confirm_date')");
        $dao = new HistoryRecordDao($db);
        $dao->add($object);
    }

    public function testUpdateNotHistoryRecordExpectInvalidArgumentException()
    {
        $object = "test";
        $db = $this->createMysqliQuerySpy(null);
        $dao = new HistoryRecordDao($db);
        $this->expectException(InvalidArgumentException::class);
        $dao->update($object);
    }

    public function testUpdateHistoryRecordExpectAction()
    {
        $id = 12;
        $user_id = 14;
        $product_id = 16;
        $count = 2;
        $address = "Htlr street, 14/oooo";
        $phone = "1234567";
        $order_date = '2018-01-01';
        $confirm_date = '2018-01-02';
        $object = new HistoryRecord($id, new User($user_id, "aaaaaaa",
            "aswer@test.se", "12345678"), new Product($product_id,
            "namename", new Category(123, "lalala"), 143,
            "lalala"), $count,
            $address, $phone, $order_date, $confirm_date);
        $db = $this->createMysqliQuerySpy("UPDATE `log` SET `user_id` = '$user_id', `product_id` = '$product_id',
                  `count` = '$count', `address` = '$address', `phone` = '$phone', 
                  `order_date` = '$order_date', `confirm_date` = '$confirm_date' WHERE `id` = '$id'");
        $dao = new HistoryRecordDao($db);
        $dao->update($object);
    }

    public function testGetAllFromEmptyTableExpectEmptyArray()
    {
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `log` WHERE `confirm_date` IS NOT NULL");
        $dao = new HistoryRecordDao($this->mysqliStub);
        $expected = array();
        $actual = $dao->getAll();
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllFromNonEmptyTableExpectArrayWithObject()
    {
        $id = 12;
        $user_id = 14;
        $product_id = 16;
        $count = 2;
        $address = "Htlr street, 14/oooo";
        $phone = "1234567";
        $order_date = '2018-01-01';
        $confirm_date = '2018-01-02';
        $object = new HistoryRecord($id, new User($user_id, "aaaaaaa",
            "aswer@test.se", "12345678"), new Product($product_id,
            "namename", new Category(123, "lalala"), 143,
            "lalala"), $count,
            $address, $phone, $order_date, $confirm_date);
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `log` WHERE `confirm_date` IS NOT NULL");
        $dao = $this->construct(HistoryRecordDao::class, [$this->mysqliStub],
            ["convert" => function($obj) { return $obj; }]);
        $expected = array($object);
        $actual = $dao->getAll();
        $this->assertEquals($expected, $actual);
    }

    public function testGetByFromEmptyTableExpectEmptyArray()
    {
        $column_name = "column_name";
        $value = "val";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `log` WHERE `$column_name` = '$value' 
                                 AND `confirm_date` IS NOT NULL");
        $dao = new HistoryRecordDao($this->mysqliStub);
        $expected = array();
        $actual = $dao->getBy($column_name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testGetByFromNonEmptyTableExpectArrayWithObject()
    {
        $column_name = "column_name";
        $value = "val";
        $id = 12;
        $user_id = 14;
        $product_id = 16;
        $count = 2;
        $address = "Htlr street, 14/oooo";
        $phone = "1234567";
        $order_date = '2018-01-01';
        $confirm_date = '2018-01-02';
        $object = new HistoryRecord($id, new User($user_id, "aaaaaaa",
            "aswer@test.se", "12345678"), new Product($product_id,
            "namename", new Category(123, "lalala"), 143,
            "lalala"), $count,
            $address, $phone, $order_date, $confirm_date);
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `log` WHERE `$column_name` = '$value' 
                                 AND `confirm_date` IS NOT NULL");
        $dao = $this->construct(HistoryRecordDao::class, [$this->mysqliStub],
            ["convert" => function($obj) { return $obj; }]);
        $expected = array($object);
        $actual = $dao->getBy($column_name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testGetColumnByFromEmptyTableExpectEmptyArray()
    {
        $get_column = "get_column";
        $column = "column";
        $value = "val";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT `$get_column` FROM `log` WHERE `$column` = '$value'
                                      AND `confirm_date` IS NOT NULL");
        $dao = new HistoryRecordDao($this->mysqliStub);
        $expected = array();
        $actual = $dao->getColumnBy($column, $value, $get_column);
        $this->assertEquals($expected, $actual);
    }

    public function testGetColumnByFromNonEmptyTableExpectArrayWithObject()
    {
        $get_column = "get_column";
        $column = "column";
        $value = "val";
        $object = array($get_column => "test");
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT `$get_column` FROM `log` WHERE `$column` = '$value'
                                      AND `confirm_date` IS NOT NULL");
        $dao = $this->construct(HistoryRecordDao::class, [$this->mysqliStub],
            ["convert" => function($obj) { return $obj; }]);
        $expected = array("test");
        $actual = $dao->getColumnBy($column, $value, $get_column);
        $this->assertEquals($expected, $actual);
    }

    private function generateMysqliResultStub($obj=false)
    {
        $this->iterate = 1;
        $this->obj = $obj;
        $this->mysqliResultStub
            = $this->make(mysqli_result::class,
            ["fetch_assoc" => function()
            {
                if ($this->iterate == 1) {
                    $this->iterate = 2;
                    return $this->obj;
                }
                return false;
            }]);
    }

    private function generateMysqliStub($resultStub, $queryStr)
    {
        $this->mysqliResultStub = $resultStub;
        $this->queryStr = $queryStr;
        $this->mysqliStub = $this->make(mysqli::class,
            ["query" => function($queryS)
            {
                if ($this->queryStr == $queryS)
                {
                    return $this->mysqliResultStub;
                }
                return null;
            }]);
    }

    private function createMysqliQuerySpy($expectedParam)
    {
        $this->expectedParam = $expectedParam;
        return $this->make(mysqli::class,
            ["query" => function($actualParam)
            { $this->assertEquals($this->expectedParam, $actualParam); }]);
    }
}
