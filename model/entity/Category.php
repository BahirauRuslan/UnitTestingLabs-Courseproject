<?php

require_once "Identificational.php";

class Category extends Identificational
{
    private $name;

    public function __construct($id, $name)
    {
        parent::__construct($id);
        $this->setName($name);
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (strlen($name) >= 2 && strlen($name) <= 64)
        {
            $this->name = $name;
        }
        else
        {
            throw new InvalidArgumentException("name");
        }
    }
}
