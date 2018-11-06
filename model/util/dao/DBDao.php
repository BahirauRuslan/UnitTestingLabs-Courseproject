<?php

require_once "IDao.php";

abstract class DBDao implements IDao
{
    private $db;
    private $table_name;

    protected abstract function convert($rec);

    public function __construct($mysqli, $table_name)
    {
        $this->db = $mysqli;
        $this->table_name = $table_name;
    }

    public function getAll()
    {
        $items = array();
        $records = $this->getDb()->query("SELECT * FROM `$this->table_name`");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $this->convert($rec);
        }
        return $items;
    }

    public function getAllSearched($column, $pattern="%", $sort_column="", $desc=false)
    {
        $items = array();
        if ($sort_column != "")
        {
            $records = $this->getDb()->query("SELECT * FROM `$this->table_name` WHERE `$column` LIKE '$pattern'");
        }
        else if ($desc)
        {
            $records = $this->getDb()->query("SELECT * FROM `$this->table_name` WHERE `$column` LIKE '$pattern'
                  ORDER BY `$sort_column` DESC");
        }
        else
        {
            $records = $this->getDb()->query("SELECT * FROM `$this->table_name` WHERE `$column` LIKE '$pattern'
                  ORDER BY `$sort_column`");
        }

        while ($rec = $records->fetch_assoc())
        {
            $items[] = $this->convert($rec);
        }
        return $items;
    }

    public function getBy($column_name, $value)
    {
        $items = array();
        $records = $this->getDb()->query("SELECT * FROM `$this->table_name` WHERE `$column_name` = '$value'");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $this->convert($rec);
        }
        return $items;
    }

    public function getColumnBy($column, $value, $get_column)
    {
        $items = array();
        $records = $this->getDb()->query("SELECT `$get_column` FROM `$this->table_name` WHERE `$column` = '$value'");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $rec[$get_column];
        }
        return $items;
    }

    public function updateColumnBy($column, $value, $update_column, $update_value)
    {
        $this->getDb()->query("UPDATE `$this->table_name` 
        SET `$update_column` = '$update_value' WHERE `$column` = '$value'");
    }

    public function deleteBy($column_name, $value)
    {
        $this->getDb()->query("DELETE FROM `$this->table_name` WHERE `$column_name` = '$value'");
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        if ($db instanceof mysqli)
        {
            $this->db = $db;
        }
        else
        {
            throw new InvalidArgumentException('db');
        }
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function setTableName($table_name)
    {
        $this->table_name = $table_name;
    }
}