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
        foreach ($_SESSION as $key)
        {
            if (substr_count($key, "product_id:") == 1)
            {
                $prod_id = str_replace("product_id:", "", $key);
                $prod_count = $_SESSION[$key];
                require_once "D:\Workspace\UnitTesting\courseproject\model\util\connectDB.php";
                $productDao = new ProductDao($mysqli);
                $product =$productDao->getBy('id', $prod_id)[0];
                $records[] = new CartRecord($product, $prod_count);
            }
        }
        return $records;
    }

    public function getBy($id)
    {
        $key = "product_id" . $id;
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
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
}
