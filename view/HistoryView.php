<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\dao\HistoryRecordDao.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\URIResolver.php";

class HistoryView
{
    public function viewAll($db) {
        $dao = new HistoryRecordDao($db);
        $history = $dao->getAll();
        $uriRes = URIResolver::getURIResolver();
        $clear_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
            'clear_history', 1);
        echo "<a href='$clear_link'>Очистить историю</a>";
        foreach ($history as $record)
        {
            $id = $record->getId();
            $user_name = ($record->getUser() == null)
                ? 'none(guest)' : $record->getUser()->getLogin();
            $product_name = $record->getProduct()->getName();
            $price = $record->getProduct()->getPrice() . '$';
            $count = $record->getCount();
            $order_date = $record->getOrderDate();
            $confirm_date = $record->getConfirmDate();
            $delete_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                'delete_history', $id);
            echo "<div class='item'>
                    <div class='item_txt'>$product_name, пользователь: $user_name, $price$ x $count,
                    дата оформления: $order_date, дата подтверждения: $confirm_date</div>
                    <div class='item_control'><a href='$delete_link'>Удалить</a></div>
                  </div>";
        }
    }

    public function viewAllByUser($db, $user_id) {
        $dao = new HistoryRecordDao($db);
        $history = $dao->getBy('user_id', $user_id);
        $uriRes = URIResolver::getURIResolver();
        $clear_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
            'clear_history', $user_id);
        echo "<a href='$clear_link'>Очистить историю</a>";
        foreach ($history as $record)
        {
            $id = $record->getId();
            $product_name = $record->getProduct()->getName();
            $price = $record->getProduct()->getPrice() . '$';
            $count = $record->getCount();
            $order_date = $record->getOrderDate();
            $confirm_date = $record->getConfirmDate();
            $delete_link = $uriRes->setToURI($uriRes->getOnlyValues($_SERVER['REQUEST_URI']),
                'delete_history', $id);
            echo "<div class='item'>
                    <div class='item_txt'>$product_name, $price$ x $count, дата оформления: $order_date, 
                    дата подтверждения: $confirm_date</div>
                    <div class='item_control'><a href='$delete_link'>Удалить</a></div>
                  </div>";
        }
    }
}