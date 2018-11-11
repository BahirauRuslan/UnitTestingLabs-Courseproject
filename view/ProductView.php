<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\ProductDao.php";

class ProductView
{
    public function viewGoods($db, $pattern, $sort_column, $desc)
    {
        $dao = new ProductDao($db);
        $goods = $dao->getAllSearched('name', $pattern, $sort_column, $desc);
        foreach ($goods as $product)
        {
            $id = $product->getId();
            $name = $product->getName();
            $price = $product->getPrice();
            echo "<div class='product'>
                <div class='name_block'><a href='goodPage.php?product_id=$id'>$name</a></div>
                <div class='price_block'>$price$</div>
                <div class='control_block'>
                    <a href='goodSet.php?product=$id'>Изменить</a>
                    <a href='?delete_product=$id'>Удалить</a>
                </div>
              </div>";
        }
        if (count($goods) == 0)
        {
            echo "<p>Товаров с таким названием не найдено</p>";
        }
    }

    public function viewGoodsByCategory($db, $pattern, $sort_column, $desc, $category_id)
    {
        $dao = new ProductDao($db);
        $goods = $dao->getAllSearched('name', $pattern, $sort_column, $desc);
        foreach ($goods as $product)
        {
            if ($product->getCategory()->getId() == $category_id) {
                $id = $product->getId();
                $name = $product->getName();
                $price = $product->getPrice();
                echo "<div class='product'>
                    <div class='name_block'><a href='goodPage.php?product_id=$id'>$name</a></div>
                    <div class='price_block'>$price$</div>
                  </div>";
            }
        }
        if (count($goods) == 0)
        {
            echo "<p>Товаров с таким названием не найдено</p>";
        }
    }
}