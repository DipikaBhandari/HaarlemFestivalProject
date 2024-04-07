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

    public function updateTicketStatus( $qrHash, $status)
    {
        return $this->orderRepository->updateTicketStatus($qrHash, $status);
    }

    public function createTicket($orderItemId)
    {
        try{
            //get ticketData
            $ticketData = $this->orderRepository->getTicketById($orderItemId);
            //generate pdf with ticketData
            $ticketData['pdfPath'] =  $this->pdfService->createTicket($ticketData);
            return $ticketData;
        } catch (\Exception $e) {
            error_log("An error occurred while creating the ticket: " . $e->getMessage());
            return null;
        }
    }

    public function createInvoice($orderId)
    {
        try{
            $invoiceData = $this->orderRepository->getInvoiceData($orderId);
            //extract orderDetails and orderItems
            $order = $invoiceData;
            $orderItems = $invoiceData['orderItems'];

            // Generate PDF using the order details and order items
            $pdfPath = $this->pdfService->createInvoice($order, $orderItems);

            // Add the PDF path to the $order array
            $order['pdfPath'] = $pdfPath;

            return $order;
        } catch (\Exception $e) {
            error_log("An error occurred while creating the invoice: " . $e->getMessage());
            return null;
        }
    }
	
    public function getOrderDetails(){
        return $this->orderRepository->getOrderDetails();
    }

    public function getOrderItemsIdByOrder($orderId)
    {
        return $this->orderRepository->getOrderItemsIdByOrder($orderId);
    }

    private function addQRHash($orderId)
    {
        $this->orderRepository->addQRHash($orderId);
    }

    public function finalizeOrder($orderId)
    {
        $this->addQRHash($orderId);
        $this->orderRepository->finalizeOrder($orderId);
    }
}