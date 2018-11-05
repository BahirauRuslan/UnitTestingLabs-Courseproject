<?php

require_once "IDao.php";

abstract class DBDao implements IDao
{
    private $db;

    public abstract function getBy($column_name, $value);
    public abstract function deleteBy($column_name, $value);
    public abstract function getColumnBy($column, $value, $get_column);
    public abstract function updateColumnBy($column, $value, $update_column, $update_value);

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
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
}