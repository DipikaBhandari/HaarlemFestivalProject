<?php

namespace App\Controllers;

use App\service\qrCodeService;

class orderController
{
    private $orderService;
    private $emailService;
    public function index(){
        //remove when code combined
        $this->sendTicket(63);
    }
    public function __construct()
    {
        $this->orderService = new \App\Service\orderService();
        $this->emailService = new \App\service\emailService();
    }

    public function createOrder()
    {
        //after order is paid
        //get all details
        //verify and sanitize
        //create Order with orderId, dateOfOrder, totalPrice, vat, customerId, invoiceNr
        //invoiceNr should be something like: 'INV-date-orderId' so for example 'INV-2024-03-25-1'
        $orderId = $this->orderService->insertOrder();
        //foreach orderItem that belongs to that order:
            //update orderItems status, orderId and add qrHash
            $this->orderService->finalizeOrder($orderId, $orderItem);
            //send tickets
            $this->sendTicket($orderItem);

        //send invoice
        $this->sendInvoice($orderId);
    }

    public function scanTicket(){
        require __DIR__ . '/../views/ScanTicket.php';
    }
    public function verifyTicket() {
        // Get the raw POST data
        $postData = file_get_contents('php://input');
        // Decode the JSON data
        $postDataArray = json_decode($postData, true);

        if (isset($postDataArray['code'])){
            $qrHash = $postDataArray['code'];
            $ticketExists = $this->orderService->getTicketWithQrCode($qrHash);

            if ($ticketExists['status'] == 'paid'){
                    $success = $this->orderService->updateTicketStatus($qrHash, 'scanned');
                    if ($success){
                        $response = array(
                            'success' => true,
                            'message' => 'Ticket is valid for ' . $ticketExists['numberOfTickets'] . ' people.'
                        );
                        echo json_encode($response);
                    } else{
                        $response = array(
                            'success' => false,
                            'message' => 'There was a problem with updating the ticket status. Please try again.'
                        );
                        echo json_encode($response);
                    }
            }else {
                $response = array(
                    'success' => false,
                    'message' => 'This ticket has already been used.'
                );
                echo json_encode($response);
            }
        } else{
            $response = array(
                'success' => false,
                'message' => 'This is not a valid ticket.'
            );
            echo json_encode($response);
        }
    }

    public function sendTicket($orderItemId){
        $ticketData = $this->orderService->createTicket($orderItemId);
        $this->emailService->sendTicketEmail($ticketData);
    }

    public function sendInvoice($orderId){
        $invoiceData = $this->orderService->createInvoice($orderId);
        $this->emailService->sendInvoiceEmail($invoiceData);
    }
}