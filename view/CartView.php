<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\CartDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\URIResolver.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\Cashier.php";

class CartView
{
    public function view()
    {
        $dao = new CartDao();
        $cart = $dao->getAll();
        $uriRes = URIResolver::getURIResolver();
        foreach ($cart as $record) {
            $id = $record->getProduct()->getId();
            $name = $record->getProduct()->getName();
            $price = $record->getProduct()->getPrice();
            $count = $record->getCount();
            $delete_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                'delete_rec', $id);
            echo "<div class='item'>
                    <div class='item_txt'>$name (x $count) $price$</div>
                    <div class='item_control'><a href='$delete_link'>Удалить</a></div>
                  </div>";
        }
        if (count($cart) == 0)
        {
            echo "<a href = 'http://localhost:63342/courseproject/index.php'>
                Корзина пуста. Добавьте что-нибудь</a>";
        }
        else
        {
            $price = Cashier::getCashier()->getTotalPrice($cart);
            echo "<p>Общая стоимость: $price$</p>";
            echo "<a href = '/courseproject/createOrder.php'>
                Оформить заказ</a>";
        }
    }
}