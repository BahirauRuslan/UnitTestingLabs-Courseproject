<?php

require_once "OrderRecord.php";

class HistoryRecord extends OrderRecord
{
    private $confirmDate;

    public function __construct($id, $user, $product, $count, $address,
                                $phone, $orderDate, $confirmDate)
    {
        parent::__construct($id, $user, $product, $count, $address, $phone,
            $orderDate);
        $this->setConfirmDate($confirmDate);
    }

    public function getConfirmDate()
    {
        return $this->confirmDate;
    }

    public function setConfirmDate($confirmDate)
    {
        if (date_create_from_format("Y-m-d", $confirmDate)
            && $confirmDate <= date("Y-m-d")
            && $confirmDate >= $this->getOrderDate())
        {
            $this->confirmDate = $confirmDate;
        }
        else
        {
            throw new InvalidArgumentException("confirmDate");
        }
    }
}
