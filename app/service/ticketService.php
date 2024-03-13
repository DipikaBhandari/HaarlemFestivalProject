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

    public function createOrder($newOrderItem)
    {
        return $this->ticketRepository->createOrder($newOrderItem);
    }
}