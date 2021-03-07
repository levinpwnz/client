<?php


namespace App;

class Transaction
{
    /**
     * Transaction id
     * @var
     */
    public $transaction_id;
    /**
     * Transaction amount without fee
     * @var
     */
    public $sum;
    /**
     * Commission fee
     * @var $commissionFee
     */
    public $commissionFee;
    /**
     * Number of order
     * @var $orderNumber
     */
    public $orderNumber;


    public function __toString(): string
    {
        return \json_encode($this, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
    }

    /**
     * @param mixed $transaction_id
     * @return Transaction
     */
    public function setTransactionId($transaction_id): Transaction
    {
        $this->transaction_id = $transaction_id;
        return $this;
    }

    /**
     * @param mixed $orderNumber
     * @return Transaction
     */
    public function setOrderNumber($orderNumber): Transaction
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @param mixed $commissionFee
     * @return Transaction
     */
    public function setCommissionFee($commissionFee): Transaction
    {
        $this->commissionFee = $commissionFee;
        return $this;
    }

    /**
     * @param mixed $sum
     * @return Transaction
     */
    public function setSum($sum): Transaction
    {
        $this->sum = $sum;
        return $this;
    }
}
