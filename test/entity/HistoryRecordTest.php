<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\HistoryRecord.php";

class HistoryRecordTest extends PHPUnit_Framework_TestCase
{

    private static $historyRecord;

    protected function setUp()
    {
        self::$historyRecord = new HistoryRecord(11,
            new User(12, "login", "email@mail.by", "password"),
            new Product(11, "produ", new Category(12, "lalala"), 13, "..."),
            12, "vul 23.", "9111119", "2018-10-29", "2018-10-30");
    }

    protected function tearDown()
    {
        self::$historyRecord = null;
    }

    public function testSetConfirmDateFalseDateInvalidArgumentException()
    {
        self::expectException(InvalidArgumentException::class);
        $date = "2018-10-28";
        self::$historyRecord->setConfirmDate($date);
    }

    public function testSetConfirmDateTrueDateDate()
    {
        $expected = "2018-10-29";
        self::$historyRecord->setConfirmDate($expected);
        $actual = self::$historyRecord->getConfirmDate();
        self::assertEquals($expected, $actual);
    }
}
