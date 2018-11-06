<?php

require_once "IdentificationalDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\Category.php";

class CategoryDao extends IdentificationalDao
{
    public function __construct($db)
    {
        parent::__construct($db, 'categories');
    }

    public function add($record)
    {
        if ($record instanceof Category)
        {
            $name = $record->getName();
            $table_name = $this->getTableName();
            $this->getDb()->query("INSERT INTO `$table_name` (`name`) 
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
            $table_name = $this->getTableName();
            $this->getDb()->query("UPDATE `$table_name` SET `name` = '$name' WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("category");
        }
    }

    protected function convert($rec)
    {
        return new Category($rec['id'], $rec['name']);
    }
}

//require_once "D:\Workspace\UnitTesting\courseproject\model\util\connectDB.php";
//$dao = new CategoryDao($mysqli);
//var_dump($dao->getColumnBy('id', 7, 'picture_path'));
