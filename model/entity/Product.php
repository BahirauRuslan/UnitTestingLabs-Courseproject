<?php

require_once "Category.php";

class Product extends Identificational
{
    private $name;
    private $category;
    private $price;
    private $description;

    public function __construct($id, $name, $category, $price, $description)
    {
        parent::__construct($id);
        $this->setName($name);
        $this->setCategory($category);
        $this->setPrice($price);
        $this->setDescription($description);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (strlen($name) >= 5 && strlen($name) <= 128)
        {
            $this->name = $name;
        }
        else
        {
            throw new InvalidArgumentException("name");
        }
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        if ($category instanceof Category)
        {
            $this->category = $category;
        }
        else
        {
            throw new InvalidArgumentException("category");
        }
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if (is_numeric($price) && $price >= 0
            && $price <= pow(2, 32))
        {
            $this->price = $price;
        }
        else
        {
            throw new InvalidArgumentException("price");
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        if (strlen($description) <= 10000)
        {
            $this->description = $description;
        }
        else
        {
            throw new InvalidArgumentException("description");
        }
    }
}
