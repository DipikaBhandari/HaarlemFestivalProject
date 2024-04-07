<?php

namespace App\model;

class order
{
    private array $orderItems;

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

    public function setOrderItems(array $orderItems): void
    {
        $this->orderItems = $orderItems;
    }

    private int $orderId;

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     */
    public function setTotalPrice(int $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    private \DateTime $dateOfOrder;

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    private User $customerId;

    public function getCustomerId(): User
    {
        return $this->customerId;
    }

    public function setCustomerId(User $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getDateOfOrder(): \DateTime
    {
        return $this->dateOfOrder;
    }

    public function setDateOfOrder(\DateTime $dateOfOrder): void
    {
        $this->dateOfOrder = $dateOfOrder;
    }

    private int $totalPrice;

    public function __construct()
    {
        $this->customerId = new User();
        $this->orderItems = array();
    }
}