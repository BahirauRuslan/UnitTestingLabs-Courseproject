<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\OrderRecordDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\URIResolver.php";

class OrderView
{
    public function view($db)
    {
        $dao = new OrderRecordDao($db);
        $orders = $dao->getAll();
        $uriRes = URIResolver::getURIResolver();
        foreach ($orders as $order)
        {
            $id = $order->getId();
            $user_name = ($order->getUser() == null)
                ? 'none(guest)' : $order->getUser()->getLogin();
            $product_name = $order->getProduct()->getName();
            $product_price = $order->getProduct()->getPrice();
            $count = $order->getCount();
            $date = $order->getOrderDate();
            $submit_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                'submit_order', $id);
            $delete_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                'delete_order', $id);
            echo "<div class='item'>
                    <div class='item_txt'>Пользователь: $user_name, $product_name $product_price$ x  $count,
                    дата оформления: $date</div>
                    <div class='item_control'>
                    <a href='$submit_link'>Подтвердить</a>
                    <a href='$delete_link'>Удалить</a>
                    </div>
                  </div>";
        }
    }
}