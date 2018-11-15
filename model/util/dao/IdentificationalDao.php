<?php

require_once "DBDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\Identificational.php";

abstract class IdentificationalDao extends DBDao
{

    public function __construct($mysqli, $table_name)
    {
        parent::__construct($mysqli, $table_name);
    }

    public function delete($record)
    {
        if ($record instanceof Identificational)
        {
            $id = $record->getId();
            $table_name = $this->getTableName();
            $this->getDb()->query("DELETE FROM `$table_name` WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("Non-id-able");
        }
    }
}