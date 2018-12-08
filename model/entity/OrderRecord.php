<?php

require_once "User.php";
require_once "Product.php";

class OrderRecord extends Identificational
{
    private $user;
    private $product;
    private $count;
    private $address;
    private $phone;
    private $orderDate;

    public function __construct($id, $user, $product, $count, $address,
                                $phone, $orderDate)
    {
        parent::__construct($id);
        $this->setUser($user);
        $this->setProduct($product);
        $this->setCount($count);
        $this->setAddress($address);
        $this->setPhone($phone);
        $this->setOrderDate($orderDate);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        if ($product instanceof Product)
        {
            $this->product = $product;
        }
        else
        {
            throw new InvalidArgumentException("product");
        }
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        if (is_numeric($count)
            && $count >= 1 && $count <= 256)
        {
            $this->count = $count;
        }
        else
        {
            throw new InvalidArgumentException("count");
        }
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        if (strlen($address) >= 7
            && strlen($address) <= 100)
        {
            $this->address = $address;
        }
        else
        {
            throw new InvalidArgumentException("address");
        }
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        if (strlen($phone) == 7 && is_numeric($phone))
        {
            $this->phone = $phone;
        }
        else
        {
            throw new InvalidArgumentException("phone");
        }
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate)
    {
        if (date_create_from_format("Y-m-d", $orderDate)
            && $orderDate <= date("Y-m-d"))
        {
            $this->orderDate = $orderDate;
        }
        else
        {
            throw new InvalidArgumentException("orderDate");
        }
    }
}
