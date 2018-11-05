<?php

require_once "DBDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\Category.php";

class CategoryDao extends DBDao
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getAll()
    {
        $categories = array();
        $records = $this->getDb()->query("SELECT * FROM `categories`");
        while ($rec = $records->fetch_assoc())
        {
            $categories[] = $this->convertToCategory($rec);
        }
        return $categories;
    }

    public function add($record)
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

    public function update($record)
    {
        if ($record instanceof Category)
        {
            $id = $record->getId();
            $name = $record->getName();
            $this->getDb()->query("UPDATE `categories` SET `name` = '$name' WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("category");
        }
    }

    public function delete($record)
    {
        if ($record instanceof Category)
        {
            $id = $record->getId();
            $this->getDb()->query("DELETE FROM `categories` WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("category");
        }
    }

    public function updateColumnBy($column, $value, $update_column, $update_value)
    {
        $this->getDb()->query("UPDATE `categories` 
        SET `$update_column` = '$update_value' WHERE `$column` = '$value'");
    }

    public function getColumnBy($column, $value, $get_column)
    {
        $items = array();
        $records = $this->getDb()->query("SELECT `$get_column` FROM `categories` WHERE `$column` = '$value'");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $rec[$get_column];
        }
        return $items;
    }

    public function getBy($column_name, $value)
    {
        $items = array();
        $records = $this->getDb()->query("SELECT * FROM `categories` WHERE `$column_name` = '$value'");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $this->convertToCategory($rec);
        }
        return $items;
    }

    public function deleteBy($column_name, $value)
    {
        $this->getDb()->query("DELETE FROM `categories` WHERE `$column_name` = '$value'");
    }

    private function convertToCategory($rec)
    {
        return new Category($rec['id'], $rec['name']);
    }
}
