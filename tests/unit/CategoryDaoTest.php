<?php

require_once __DIR__ . '\..\..\model\util\dao\CategoryDao.php';

class CategoryDaoTest extends \Codeception\Test\Unit
{
    private $expectedParam;

    private function createMysqliQuerySpy($expectedParam)
    {
        $this->expectedParam = $expectedParam;
        return $this->make(mysqli::class,
            ["query" => function($actualParam)
            { $this->assertEquals($this->expectedParam, $actualParam); }]);
    }

    public function testAddNotCategoryExpectInvalidArgumentException()
    {
        $dummy = $this->make(mysqli::class);
        $categoryDao = new CategoryDao($dummy);
        $notCategoryObject = "test";
        $this->expectException(InvalidArgumentException::class);
        $categoryDao->add($notCategoryObject);
    }

    public function testAddCategoryExpectQuery()
    {
        $name = "Motherboards";
        $category = new Category(12, $name);
        $table_name = 'categories';
        $query = "INSERT INTO `$table_name` (`name`) 
            VALUES ('$name')";
        $mysqliSpy = $this->createMysqliQuerySpy($query);
        $categoryDao = new CategoryDao($mysqliSpy);
        $categoryDao->add($category);
    }

    public function testUpdateNotCategoryExpectInvalidArgumentException()
    {
        $dummy = $this->make(mysqli::class);
        $categoryDao = new CategoryDao($dummy);
        $notCategoryObject = "test";
        $this->expectException(InvalidArgumentException::class);
        $categoryDao->update($notCategoryObject);
    }

    public function testUpdateCategoryExpectQuery()
    {
        $id = 123;
        $name = "Motherboards";
        $category = new Category($id, $name);
        $table_name = 'categories';
        $query = "UPDATE `$table_name` SET `name` = '$name' WHERE `id` = '$id'";
        $mysqliSpy = $this->createMysqliQuerySpy($query);
        $categoryDao = new CategoryDao($mysqliSpy);
        $categoryDao->update($category);
    }
}
