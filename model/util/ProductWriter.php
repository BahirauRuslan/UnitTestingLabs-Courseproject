<?php

require_once "DBWriter.php";
require_once "Modifier.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\Product.php";

class ProductWriter extends DBWriter implements Modifier
{
    public function write($record)
    {
        if ($record instanceof Product)
        {
            $name = $record->getName();
            $price = $record->getPrice();
            $category_id = $record->getCategory()->getId();
            $description = $record->getDescription();
            $this->getDb()->query("INSERT INTO `products` 
              (`name`, `price`, `category_id`, `description`)  
              VALUES ('$name', '$price', '$category_id', '$description')");
        }
        else
        {
            throw new InvalidArgumentException("product");
        }
    }

    public function modify($record)
    {
        // TODO: Implement modify() method.
    }

    public function writeWithPic($record, $pic_path=null)
    {
        if ($pic_path === null)
        {
            $this->write($record);
        }
        else if ($record instanceof Product)
        {
            $name = $record->getName();
            $price = $record->getPrice();
            $category_id = $record->getCategory()->getId();
            $description = $record->getDescription();
            $this->getDb()->query("INSERT INTO `products` 
              (`name`, `price`, `category_id`, `description`, `picture_path`)  
              VALUES ('$name', '$price', '$category_id', '$description', '$pic_path')");
        }
        else
        {
            throw new InvalidArgumentException("product");
        }
    }
}