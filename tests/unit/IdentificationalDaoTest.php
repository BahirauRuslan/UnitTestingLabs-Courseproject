<?php

require_once __DIR__ . '\..\..\model\util\dao\IdentificationalDao.php';

class IdentificationalDaoTest extends \Codeception\Test\Unit
{
    private $expectedParam;

    public function testDeleteNotIdentificationalExpectInvalidArgumentException()
    {
        $spy = $this->createMysqliQuerySpy(null);
        $dao = $this->createIdentificationalDaoStub($spy);
        $this->expectException(InvalidArgumentException::class);
        $dao->delete("test");
    }

    public function testDeleteIdentificationalExpectAction()
    {
        $id = 14;
        $identificational = $this->make(Identificational::class, ["getId" => $id]);
        $spy = $this->createMysqliQuerySpy("DELETE FROM `name` WHERE `id` = '$id'");
        $dao = $this->createIdentificationalDaoStub($spy);
        $dao->delete($identificational);
    }

    private function createMysqliQuerySpy($expectedParam)
    {
        $this->expectedParam = $expectedParam;
        return $this->make(mysqli::class,
            ["query" => function($actualParam)
            { $this->assertEquals($this->expectedParam, $actualParam); }]);
    }

    private function createIdentificationalDaoStub($mysqliSpy)
    {
        return $this->construct(IdentificationalDao::class,
            [$mysqliSpy, "table_name" => "name"], [
                "convert" => function($obj) {return $obj;},
                "add" => null,
                "update" => null]);
    }
}
