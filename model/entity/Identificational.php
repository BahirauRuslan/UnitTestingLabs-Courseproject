<?php

class Identificational
{
    private $id;

    protected function __construct($id)
    {
        $this->setId($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (is_numeric($id) && $id >= 0 && $id <= pow(2, 32))
        {
            $this->id = $id;
        }
        else
        {
            throw new InvalidArgumentException("id");
        }
    }
}
