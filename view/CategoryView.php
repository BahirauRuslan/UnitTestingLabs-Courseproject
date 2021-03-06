<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\CategoryDao.php";

class CategoryView
{
    public function consumerView($db)
    {
        $dao = new CategoryDao($db);
        $categories = $dao->getAll();
        $name_left = true;
        foreach ($categories as $category)
        {
            $id = $category->getId();
            $name = $category->getName();
            require_once "paths.php";
            $picture = $PIC_CATEGORIES_PATH . $dao->getColumnBy('id', $id, 'picture_path')[0];
            $blocks = "";
            if ($name_left)
            {
                $blocks = "<div class=\"category_txt\">$name</div><div class='category_fill'></div>
                        <div class='right_block'><img src=\"$picture\" /></div>";
            }
            else
            {
                $blocks = "<div><img src=\"$picture\" /></div>
                        <div class='right_block'><div class=\"category_txt\">$name</div></div>";
            }
            $name_left = !$name_left;
            echo "<div class=\"category\">
                    <a href=\"goods.php?category=$id\">"
                        . $blocks .
                    "</a>
                  </div>";
        }
    }

    public function adminView($db)
    {
        $dao = new CategoryDao($db);
        $categories = $dao->getAll();
        foreach ($categories as $category)
        {
            $id = $category->getId();
            $name = $category->getName();
            echo "<div class='item'>
                    <div class='item_txt'>$name</div>
                    <div class='item_control'><a href='?delete_category=$id'>Удалить</a></div>
                  </div>";
        }
    }

    public function adminSelectView($db)
    {
        $dao = new CategoryDao($db);
        $categories = $dao->getAll();
        foreach ($categories as $category)
        {
            $id = $category->getId();
            $name = $category->getName();
            echo "
                    <div><a href='goodSet.php?category=$id'>$name</a></div>
                  ";
        }
    }
}