<?php

namespace App\Service;

class orderService
{
    private $orderRepository;
    private $pdfService;
    public function __construct()
    {
        $this->orderRepository = new \App\Repositories\orderRepository();
        $this->pdfService = new \App\service\pdfService();
    }

    public function getTicketWithQrCode($qrHash)
    {
        return $this->orderRepository->getTicketWithQRCode($qrHash);
    }

    public function updateTicketStatus( $qrHash,  $status)
    {
        return $this->orderRepository->updateTicketStatus($qrHash, $status);
    }

    public function finalizeOrder($orderId, $orderItem)
    {
        $orderItemId = $orderItem['orderItemId'];
        $userId = $orderItem['userId'];
        $eventName = $orderItem['eventName'];
        $dataToHash = $orderItemId . $userId . $eventName;
        $qrHash = hash('sha256', $dataToHash);
        $orderItem['qrHash'] = $qrHash;
        $orderItem['status'] = 'paid';
        return $this->orderRepository->finalizeOrder($orderId, $orderItem);
    }

    public function createTicket($orderItemId)
    {
        //get ticketData
        $ticketData = $this->orderRepository->getTicketById($orderItemId);
        //generate pdf with ticketData
        $ticketData['pdfPath'] =  $this->pdfService->createTicket($ticketData);
        return $ticketData;
    }

    public function createInvoice($orderId)
    {
        $invoiceData = $this->orderRepository->getInvoiceData($orderId);
        //extract orderDetails and orderItems
        $order = $invoiceData;
        $orderItems = $invoiceData['orderItems'];

        // Generate PDF using the order details and order items
        $pdfPath = $this->pdfService->createInvoice($order, $orderItems);

        // Add the PDF path to the $order array
        $order['pdfPath'] = $pdfPath;

        return $order;
    }
}