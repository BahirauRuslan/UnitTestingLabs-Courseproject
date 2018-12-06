<?php

require_once __DIR__ . '\..\..\model\entity\HistoryRecord.php';

class HistoryRecordTest extends \Codeception\Test\Unit
{
    private static $historyRecord;

    protected $tester;
    
    protected function _before()
    {
        self::$historyRecord = new HistoryRecord(11,
            new User(12, "login", "email@mail.by", "password"),
            new Product(11, "produ", new Category(12, "lalala"), 13, "..."),
            12, "vul 23.", "9111119", "2018-10-29", "2018-10-30");
    }

    protected function _after()
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