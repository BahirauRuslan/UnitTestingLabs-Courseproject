<?php

require_once "IdentificationalDao.php";
require_once "UserDao.php";
require_once "ProductDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\HistoryRecord.php";

class HistoryRecordDao extends IdentificationalDao
{
    public function __construct($db)
    {
        parent::__construct($db, 'log');
    }

    protected function convert($rec)
    {
        $productDao = new ProductDao($this->getDb());
        $userDao = new UserDao($this->getDb());
        $user = ($rec['user_id'] == 0) ? 0 : $userDao->getBy('id', $rec['user_id'])[0];
        $product = $productDao->getBy('id', $rec['product_id'])[0];
        return new HistoryRecord($rec['id'], $user, $product,
            $rec['count'], $rec['address'], $rec['phone'], $rec['order_date'], $rec['confirm_date']);
    }

    public function add($record)
    {
        if ($record instanceof HistoryRecord)
        {
            $user_id = ($record->getUser() == null) ? null : $record->getUser()->getId();
            $product_id = $record->getProduct()->getId();
            $count = $record->getCount();
            $address = $record->getAddress();
            $phone = $record->getPhone();
            $order_date = $record->getOrderDate();
            $confirm_date = $record->getConfirmDate();
            $table_name = $this->getTableName();
            $this->getDb()->query("INSERT INTO `$table_name` (`user_id`, `product_id`, `count`, `address`,
            `phone`, `order_date`, `confirm_date`) 
            VALUES ('$user_id', '$product_id', '$count', '$address', '$phone', '$order_date', '$confirm_date')");
        }
        else
        {
            throw new InvalidArgumentException("History record");
        }
    }

    public function update($record)
    {
        if ($record instanceof HistoryRecord)
        {
            $id = $record->getId();
            $user_id = ($record->getUser() == null) ? null : $record->getUser()->getId();
            $product_id = $record->getProduct()->getId();
            $count = $record->getCount();
            $address = $record->getAddress();
            $phone = $record->getPhone();
            $order_date = $record->getOrderDate();
            $confirm_date = $record->getConfirmDate();
            $table_name = $this->getTableName();
            $this->getDb()->query("UPDATE `$table_name` SET `user_id` = '$user_id', `product_id` = '$product_id',
                  `count` = '$count', `address` = '$address', `phone` = '$phone', 
                  `order_date` = '$order_date', `confirm_date` = '$confirm_date' WHERE `id` = '$id'");
        }
        else
        {
            throw new InvalidArgumentException("History record");
        }
    }


    public function getAll()
    {
        $items = array();
        $table_name = $this->getTableName();
        $records = $this->getDb()->query("SELECT * FROM `$table_name` WHERE `confirm_date` IS NOT NULL");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $this->convert($rec);
        }
        return $items;
    }

    public function getBy($column_name, $value)
    {
        $items = array();
        $table_name = $this->getTableName();
        $records = $this->getDb()->query("SELECT * FROM `$table_name` WHERE `$column_name` = '$value' 
                                 AND `confirm_date` IS NOT NULL");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $this->convert($rec);
        }
        return $items;
    }

    public function getColumnBy($column, $value, $get_column)
    {
        $items = array();
        $table_name = $this->getTableName();
        $records = $this->getDb()->query("SELECT `$get_column` FROM `$table_name` WHERE `$column` = '$value'
                                      AND `confirm_date` IS NOT NULL");
        while ($rec = $records->fetch_assoc())
        {
            $items[] = $rec[$get_column];
        }
        return $items;
    }

    public function updateColumnBy($column, $value, $update_column, $update_value)
    {
        $table_name = $this->getTableName();
        $this->getDb()->query("UPDATE `$table_name` 
        SET `$update_column` = '$update_value' WHERE `$column` = '$value' AND `confirm_date` IS NOT NULL");
    }

    public function deleteBy($column_name, $value)
    {
        $table_name = $this->getTableName();
        $this->getDb()->query("DELETE FROM `$table_name` WHERE `$column_name` = '$value' AND `confirm_date` IS NOT NULL");
    }
}