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
            echo "<div>
                    <div>$login</div>
                    <div></div>
                    <div></div>
                  </div>";
        }
    }
}