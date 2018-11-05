<?php

require_once "Writer.php";

abstract class DBWriter implements Writer
{
    private $db;

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

    public abstract function write($record);
}
