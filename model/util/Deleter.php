<?php

interface Deleter
{
    public function deleteBy($column_name, $value);
}