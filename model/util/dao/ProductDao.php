<?php

require_once "CategoryDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\Product.php";

class ProductDao extends IdentificationalDao
{
    public function __construct($db)
    {
        parent::__construct($db, 'products');
    }

    protected function convert($rec)
    {
        $categoryDao = new CategoryDao($this->getDb());
        $category = $categoryDao->getBy('id', $rec['category_id']);
        return new Product($rec['id'], $rec['name'], $category,
            $rec['price'], $rec['description']);
    }

    public function add($record)
    {
        // TODO: Implement add() method.
    }

    public function update($record)
    {
        // TODO: Implement update() method.
    }
}
//require_once "D:\Workspace\UnitTesting\courseproject\model\util\connectDB.php";
//$rec = $mysqli->query("SELECT * FROM `products` WHERE `id` = '1'")->fetch_assoc();
//$categoryDao = new CategoryDao($mysqli);
//$category = $categoryDao->getBy('id', $rec['category_id'])[0];
//var_dump(new Product($rec['id'], $rec['name'], $category,
//    $rec['price'], $rec['description']));
