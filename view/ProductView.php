<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\ProductDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\URIResolver.php";

class ProductView
{
    public function viewPage($db, $id, $isAdmin) {
        $dao = new ProductDao($db);
        $product = $dao->getBy('id', $id)[0];
        require "paths.php";
        $picture = $PIC_PRODUCTS_PATH
            . $dao->getColumnBy('id', $id, 'picture_path')[0];
        $name = $product->getName();
        $price = $product->getPrice();
        $description = $product->getDescription();
        $uriRes = URIResolver::getURIResolver();
        $add_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
            'add_product', $id);
        $add_div = ($isAdmin) ? "" : "<div><a href='$add_link'>Добавить в корзину</a></div>";
        echo "<div class='page_pic'><img src='$picture'></div>
              <div class='name_page'>$name</div>
              <div class='price_page'>Price: $price$</div>
              <div class='cntrl_page'>$add_div</div>
              <div>Описание:<br>$description</div>";
    }

    public function viewGoods($db, $pattern, $sort_column, $desc)
    {
        $dao = new ProductDao($db);
        $goods = $dao->getAllSearched('name', $pattern, $sort_column, $desc);
        $uriRes = URIResolver::getURIResolver();
        foreach ($goods as $product)
        {
            $id = $product->getId();
            $name = $product->getName();
            $price = $product->getPrice();
            require "paths.php";
            $picture = $PIC_PRODUCTS_PATH
                . $dao->getColumnBy('id', $id, 'picture_path')[0];
            $del_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                'delete_product', $id);
            echo "<div class='product'>
                <div class='product_pic'><img src='$picture'></div>
                <div class='info_block'>
                    <div class='name_block'><a href='goodPage.php?product_id=$id'>$name</a></div>
                    <div class='price_block'>$price$</div>
                    <div class='control_block'>
                        <a href='goodSet.php?product=$id'>Изменить</a>
                        <a href='$del_link'>Удалить</a>
                    </div>
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
        $count = 0;
        $dao = new ProductDao($db);
        $goods = $dao->getAllSearched('name', $pattern, $sort_column, $desc);
        $uriRes = URIResolver::getURIResolver();
        foreach ($goods as $product)
        {
            if ($product->getCategory()->getId() == $category_id) {
                $count++;
                $id = $product->getId();
                $name = $product->getName();
                $price = $product->getPrice();
                require "paths.php";
                $picture = $PIC_PRODUCTS_PATH
                    . $dao->getColumnBy('id', $id, 'picture_path')[0];
                $add_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                    'add_product', $id);
                echo "<div class='product'><div class='product_pic'><img src='$picture'></div>
                    <div class='info_block'>
                        <div class='name_block'><a href='goodPage.php?product_id=$id'>$name</a></div>
                        <div class='price_block'>$price$</div>
                        <a href='$add_link'>Добавить в корзину</a>
                    </div>
                  </div>";
            }
        }
        if ($count == 0)
        {
            echo "<p>Товаров с таким названием не найдено</p>";
        }
    }
}