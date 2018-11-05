<?php

interface IDao
{
    public function getAll();
    public function add($record);
    public function update($record);
    public function delete($record);
}