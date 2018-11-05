<?php

interface Reader
{
    public function readAll();
    public function readColumn($columnName);
}
