<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\UserDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\URIResolver.php";

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
            $uriRes = URIResolver::getURIResolver();
            $history_link = $uriRes->setToURI('userHistory.php', 'user', $id);
            $delete_link = $uriRes->setToURI('', 'delete_user', $id);
            echo "<div class='item'>
                    <div>$login</div>
                    <div><a href=$history_link>История заказов</a></div>
                    <div><a href=$delete_link>Удалить</a></div>
                  </div>";
        }
        if (count($users) == 0)
        {
            echo "<p>Пользователей с таким логином не найдено</p>";
        }
    }
}