<?php

require_once __DIR__ . '\..\..\model\util\dao\ProductDao.php';

class ProductDaoTest extends \Codeception\Test\Unit
{
    private $expectedParam;

    public function testAddNotProductExpectInvalidArgumentException()
    {
        $dummy = $this->make(mysqli::class);
        $productDao = new ProductDao($dummy);
        $notProductObject = "test";
        $this->expectException(InvalidArgumentException::class);
        $productDao->add($notProductObject);
    }

    public function testAddProductExpectQuery()
    {
        $name = "Motherboard";
        $price = 231;
        $description = "lalala";
        $category_id = 14;
        $category = new Category($category_id, "test");
        $product = new Product(11, $name, $category, $price, $description);
        $table_name = 'products';
        $query = "INSERT INTO `$table_name` (`name`, `price`, `category_id`, `description`) 
            VALUES ('$name', '$price', '$category_id', '$description')";
        $mysqliSpy = $this->createMysqliQuerySpy($query);
        $productDao = new ProductDao($mysqliSpy);
        $productDao->add($product);
    }

    public function testUpdateNotProductExpectInvalidArgumentException()
    {
        $dummy = $this->make(mysqli::class);
        $productDao = new ProductDao($dummy);
        $notProductObject = "test";
        $this->expectException(InvalidArgumentException::class);
        $productDao->update($notProductObject);
    }

    public function testUpdateProductExpectQuery()
    {
        $id = 11;
        $name = "Motherboard";
        $price = 231;
        $description = "lalala";
        $category_id = 14;
        $category = new Category($category_id, "test");
        $product = new Product($id, $name, $category, $price, $description);
        $table_name = 'products';
        $query = "UPDATE `$table_name` SET `name` = '$name', `price` = '$price',
                  `category_id` = '$category_id', `description` = '$description' WHERE `id` = '$id'";
        $mysqliSpy = $this->createMysqliQuerySpy($query);
        $productDao = new ProductDao($mysqliSpy);
        $productDao->update($product);
    }

    private function createMysqliQuerySpy($expectedParam)
    {
        $this->expectedParam = $expectedParam;
        return $this->make(mysqli::class,
            ["query" => function($actualParam)
            { $this->assertEquals($this->expectedParam, $actualParam); }]);
    }
}
