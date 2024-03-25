<?php

namespace App\service;

use App\Repositories\ticketRepository;

class ticketService
{
    private ticketRepository $ticketRepository;

    public function __construct()
    {
        $this->ticketRepository = new ticketRepository();
    }
    public function getOrderByUserId($userId)
    {
        return $this->ticketRepository->getOrderByUserId($userId);
    }
    public function createOrderItem($newOrderItem, $orderId)
    {
         return $this->ticketRepository->createOrderItem($newOrderItem, $orderId);
    }
    public function getOrderIdByCustomerId($userId)
    {
        return $this->ticketRepository->getOrderIdByCustomerId($userId);
    }
    public function deleteOrderbyOrderId($orderItemId): void
    {
         $this->ticketRepository->deleteOrderbyOrderId($orderItemId);
    }

    public function getOrderIdByUserId($userId)
    {
        return $this->ticketRepository->getOrderItemIdByUserId($userId);
    }
}