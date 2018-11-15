<?php

require_once "IDao.php";
require_once "ProductDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\CartRecord.php";

class CartDao implements IDao
{
    public function add($record)
    {
        if (!is_array($record))
        {
            throw new InvalidArgumentException("not array");
        }
        foreach ($record as $rec)
        {
            if ($rec instanceof CartRecord)
            {
                $key = "product_id:" . $rec->getProduct()->getId();
                $count = $rec->getCount();
                $_SESSION[$key] = $count;
            }
        }
    }

    public function getAll()
    {
        $records = array();
        foreach (array_keys($_SESSION) as $key)
        {
            if (substr_count($key, "product_id:") == 1)
            {
                $prod_id = str_replace("product_id:", "", $key);
                $prod_count = $_SESSION[$key];
                require "D:\Workspace\UnitTesting\courseproject\model\util\connectDB.php";
                $productDao = new ProductDao($mysqli);
                $product =$productDao->getBy('id', $prod_id)[0];
                $records[] = new CartRecord($product, $prod_count);
            }
        }
        return $records;
    }

    public function getBy($id)
    {
        $key = "product_id:" . $id;
        if (isset($_SESSION[$key])) {
            $prod_count = $_SESSION[$key];
            require "D:\Workspace\UnitTesting\courseproject\model\util\connectDB.php";
            $productDao = new ProductDao($mysqli);
            $product = $productDao->getBy('id', $id)[0];
            return new CartRecord($product, $prod_count);
        }
        return false;
    }

    public function update($record)
    {
        $this->add($record);
    }

    public function delete($record)
    {
        if ($record instanceof CartRecord)
        {
            unset($_SESSION["product_id:" . $record->getProduct()->getId()]);
        }
    }

    public function deleteById($id)
    {
        if (isset($_SESSION["product_id:" . $id])) {
            unset($_SESSION["product_id:" . $id]);
        }
    }
}
