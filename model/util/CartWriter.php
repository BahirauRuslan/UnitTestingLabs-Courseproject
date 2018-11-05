<?php

require_once "session.php";
require_once "Writer.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\CartRecord.php";

class CartWriter implements Writer
{
    public function write($records)
    {
        if (!is_array($records))
        {
            throw new InvalidArgumentException("not array");
        }
        foreach ($records as $record)
        {
            if ($record instanceof CartRecord)
            {
                $key = "product_id:" . $record->getProduct()->getId();
                $count = $record->getCount();
                $_SESSION[$key] = $count;
            }
        }
    }
}
