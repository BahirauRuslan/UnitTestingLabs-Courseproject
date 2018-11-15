<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\\entity\CartRecord.php";

class Cashier
{
    private static $cashier;

    private function __construct(){}

    public static function getCashier()
    {
        if (self::$cashier === null)
        {
            self::$cashier = new self();
        }
        return self::$cashier;
    }
    
    public function getTotalPrice($cart)
    {
        $totalPrice = 0;
        if (!is_array($cart))
        {
            throw new InvalidArgumentException("not array");
        }
        foreach ($cart as $record)
        {
            if ($record instanceof CartRecord)
            {
                $totalPrice += $record->getProduct()->getPrice()
                    * $record->getCount();
            }
        }
        return $totalPrice;
    }
}
