<?php

namespace App\service;

namespace App\service;
use App\Repositories\orderRepository;
class orderService
{
    private $orderRepository;

    public function __construct() {
        $this->orderRepository = new orderRepository();
    }
    public function getOrderDetails(){
        return $this->orderRepository->getOrderDetails();
    }

}