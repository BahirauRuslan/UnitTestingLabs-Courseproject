<?php

require_once "Product.php";

class CartRecord
{
    private $product;
    private $count;

    public function __construct($product, $count)
    {
        $this->setProduct($product);
        $this->setCount($count);
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
}
