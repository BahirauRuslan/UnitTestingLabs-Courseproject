<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\UserDao.php";

class UserView
{
    public function adminView($db, $pattern)
    {
        $dao = new UserDao($db);
        $users = $dao->getAllSearched('login', $pattern, 'login');
        foreach ($users as $user)
        {
            $id = $user->getId();
            $login = $user->getLogin();
            echo "<div class='item'>
                    <div>$login</div>
                    <div><a href='userHistory.php?user=$id'>История заказов</a></div>
                    <div><a href='?delete_user=$id'>Удалить</a></div>
                  </div>";
        }
        if (count($users) == 0)
        {
            echo "<p>Пользователей с таким логином не найдено</p>";
        }
    }
}