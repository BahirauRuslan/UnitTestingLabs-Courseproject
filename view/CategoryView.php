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
            $picture = $dao->getColumnBy('id', $id, 'picture_path')[0];
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
}