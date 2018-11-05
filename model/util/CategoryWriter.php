<?php

require_once "DBWriter.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\Category.php";

class CategoryWriter extends DBWriter
{
    public function write($record)
    {
        if ($record instanceof Category)
        {
            $name = $record->getName();
            $this->getDb()->query("INSERT INTO `categories` (`name`) 
            VALUES ('$name')");
        }
        else
        {
            throw new InvalidArgumentException("category");
        }
    }

    public function writeWithPic($record, $pic_path=null)
    {
        if ($pic_path === null)
        {
            $this->write($record);
        }
        else if ($record instanceof Category)
        {
            $name = $record->getName();
            $this->getDb()->query("INSERT INTO `categories` 
              (`name`, `picture_path`)  VALUES ('$name', '$pic_path')");
        }
        else
        {
            throw new InvalidArgumentException("category");
        }
    }
}