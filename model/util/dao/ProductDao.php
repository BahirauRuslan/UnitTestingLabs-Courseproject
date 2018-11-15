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
        $category = $categoryDao->getBy('id', $rec['category_id'])[0];
        return new Product($rec['id'], $rec['name'], $category,
            $rec['price'], $rec['description']);
    }

    public function add($record)
    {
        if ($record instanceof Product)
        {
            $name = $record->getName();
            $price = $record->getPrice();
            $category_id = $record->getCategory()->getId();
            $description = $record->getDescription();
            $table_name = $this->getTableName();
            $this->getDb()->query("INSERT INTO `$table_name` (`name`, `price`, `category_id`, `description`) 
            VALUES ('$name', '$price', '$category_id', '$description')");
        }
        else
        {
            throw new InvalidArgumentException("product");
        }
    }

    public function update($record)
    {
        if ($record instanceof Product)
        {
            $id = $record->getId();
            $name = $record->getName();
            $price = $record->getPrice();
            $category_id = $record->getCategory()->getId();
            $description = $record->getDescription();
            $table_name = $this->getTableName();
            $this->getDb()->query("UPDATE `$table_name` SET `name` = '$name', `price` = '$price',
                  `category_id` = '$category_id', `description` = '$description' WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("product");
        }
    }
}
//require_once "D:\Workspace\UnitTesting\courseproject\model\util\connectDB.php";
//$dao = new ProductDao($mysqli);
//var_dump($dao->getAll());

//$rec = $mysqli->query("SELECT * FROM `products` WHERE `id` = '1'")->fetch_assoc();
//$categoryDao = new CategoryDao($mysqli);
//$category = $categoryDao->getBy('id', $rec['category_id'])[0];
//var_dump(new Product($rec['id'], $rec['name'], $category,
//    $rec['price'], $rec['description']));
