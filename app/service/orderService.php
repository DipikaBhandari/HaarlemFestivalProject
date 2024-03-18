<?php

namespace App\Service;

class orderService
{
    private $orderRepository;
    public function __construct()
    {
        $this->orderRepository = new \App\Repositories\orderRepository();
    }

    public function getTicketWithQrCode($qrHash)
    {
        return $this->orderRepository->getTicketWithQRCode($qrHash);
    }

    public function updateTicketStatus( $qrHash,  $status)
    {
        return $this->orderRepository->updateTicketStatus($qrHash, $status);
    }
}