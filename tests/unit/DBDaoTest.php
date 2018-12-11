<?php

require_once __DIR__ . '\..\..\model\util\dao\DBDao.php';

class DBDaoTest extends \Codeception\Test\Unit
{
    private $iterate;
    private $obj;
    private $queryStr;
    private $mysqliResultStub;
    private $mysqliStub;
    private $dbDaoStub;

    public function testGetAllFromEmptyTableExpectEmptyArray()
    {
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name`");
        $this->generateDBDaoStub();
        $expected = array();
        $actual = $this->dbDaoStub->getAll();
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllFromNonEmptyTableExpectArrayWithObject()
    {
        $object = array(2, "123", 14.8);
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name`");
        $this->generateDBDaoStub();
        $expected = array($object); //$object!
        $actual = $this->dbDaoStub->getAll();
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllSearchedFromEmptyTableWithoutSortColumnExpectEmptyArray()
    {
        $pattern = "%";
        $column = "column";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column` LIKE '$pattern'");
        $this->generateDBDaoStub();
        $expected = array();
        $actual = $this->dbDaoStub->getAllSearched($column, $pattern);
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllSearchedFromEmptyTableWithSortColumnAndDescExpectEmptyArray()
    {
        $pattern = "%";
        $column = "column";
        $sort_column = "sort_column";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column` LIKE '$pattern'
                  ORDER BY `$sort_column` DESC");
        $this->generateDBDaoStub();
        $expected = array();
        $actual = $this->dbDaoStub->getAllSearched(
            $column, $pattern, $sort_column, true);
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllSearchedFromEmptyTableWithSortColumnExpectEmptyArray()
    {
        $pattern = "%";
        $column = "column";
        $sort_column = "sort_column";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column` LIKE '$pattern'
                  ORDER BY `$sort_column`");
        $this->generateDBDaoStub();
        $expected = array();
        $actual = $this->dbDaoStub->getAllSearched(
            $column, $pattern, $sort_column);
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllSearchedFromNonEmptyTableWithoutSortColumnExpectArrayWithObject()
    {
        $pattern = "%";
        $column = "column";
        $object = "test";
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column` LIKE '$pattern'");
        $this->generateDBDaoStub();
        $expected = array($object);
        $actual = $this->dbDaoStub->getAllSearched($column, $pattern);
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllSearchedFromNonEmptyTableWithSortColumnAndDescExpectArrayWithObject()
    {
        $pattern = "%";
        $column = "column";
        $sort_column = "sort_column";
        $object = "test";
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column` LIKE '$pattern'
                  ORDER BY `$sort_column` DESC");
        $this->generateDBDaoStub();
        $expected = array($object);
        $actual = $this->dbDaoStub->getAllSearched(
            $column, $pattern, $sort_column, true);
        $this->assertEquals($expected, $actual);
    }

    public function testGetAllSearchedFromNonEmptyTableWithSortColumnExpectArrayWithObject()
    {
        $pattern = "%";
        $column = "column";
        $sort_column = "sort_column";
        $object = "test";
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column` LIKE '$pattern'
                  ORDER BY `$sort_column`");
        $this->generateDBDaoStub();
        $expected = array($object);
        $actual = $this->dbDaoStub->getAllSearched(
            $column, $pattern, $sort_column);
        $this->assertEquals($expected, $actual);
    }

    public function testGetByFromEmptyTableExpectEmptyArray()
    {
        $column_name = "column_name";
        $value = "value";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column_name` = '$value'");
        $this->generateDBDaoStub();
        $expected = array();
        $actual = $this->dbDaoStub->getBy($column_name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testGetByFromNonEmptyTableExpectArrayWithObject()
    {
        $column_name = "column_name";
        $value = "value";
        $object = "test";
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT * FROM `name` WHERE `$column_name` = '$value'");
        $this->generateDBDaoStub();
        $expected = array($object);
        $actual = $this->dbDaoStub->getBy($column_name, $value);
        $this->assertEquals($expected, $actual);
    }

    public function testGetColumnByFromEmptyTableExpectEmptyArray()
    {
        $get_column = "getcolumn";
        $column = "column";
        $value = "value";
        $this->generateMysqliResultStub();
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT `$get_column` FROM `name` WHERE `$column` = '$value'");
        $this->generateDBDaoStub();
        $expected = array();
        $actual = $this->dbDaoStub->getColumnBy($column, $value, $get_column);
        $this->assertEquals($expected, $actual);
    }

    public function testGetColumnByFromNonEmptyTableExpectArrayWithObject()
    {
        $get_column = "getcolumn";
        $column = "column";
        $value = "value";
        $object = array( $get_column => "test");
        $this->generateMysqliResultStub($object);
        $this->generateMysqliStub($this->mysqliResultStub,
            "SELECT `$get_column` FROM `name` WHERE `$column` = '$value'");
        $this->generateDBDaoStub();
        $expected = array("test");
        $actual = $this->dbDaoStub->getColumnBy($column, $value, $get_column);
        $this->assertEquals($expected, $actual);
    }

    private function generateMysqliResultStub($obj=false)
    {
        $this->iterate = 1;
        $this->obj = $obj;
        $this->mysqliResultStub
            = $this->make(mysqli_result::class,
            ["fetch_assoc" => function()
            {
                if ($this->iterate == 1) {
                    $this->iterate = 2;
                    return $this->obj;
                }
                return false;
            }]);
    }

    private function generateMysqliStub($resultStub, $queryStr)
    {
        $this->mysqliResultStub = $resultStub;
        $this->queryStr = $queryStr;
        $this->mysqliStub = $this->make(mysqli::class,
            ["query" => function($queryS)
            {
                if ($this->queryStr == $queryS)
                {
                    return $this->mysqliResultStub;
                }
                return null;
            }]);
    }

    private function generateDBDaoStub()
    {
        $this->dbDaoStub
            = $this->construct(DBDao::class,
            [$this->mysqliStub, "table_name" => "name"], [
                "convert" => function($obj) {return $obj;},
                "add" => null,
                "update" => null,
                "delete" => null]);
    }
}
