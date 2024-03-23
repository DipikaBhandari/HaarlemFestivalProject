<?php

namespace App\Controllers;

use App\service\qrCodeService;

class orderController
{
    private $orderService;
    private $emailService;
    public function index(){
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
        //create Order with orderId, dateOfOrder, totalPrice, vat, customerId
        $orderId = $this->orderService->insertOrder();
        //update orderItems status, orderId and add qrHash
        //foreach orderItem that belongs to that order:
        $this->orderService->finalizeOrder($orderId, $orderItem);

    }

    public function scanTicket(){
        require __DIR__ . '/../views/ScanTicket.php';
    }
    public function verifyTicket() {

        if (isset($_POST['code.data'])){
            $qrHash = $_POST['code.data'];
            $ticketExists = $this->orderService->getTicketWithQrCode($qrHash);

            if ($ticketExists['status'] == 'paid'){
                    $success = $this->orderService->updateTicketStatus($qrHash, 'scanned');
                    if ($success){
                        echo json_encode('Ticket is valid.');
                    } else{
                        echo json_encode('There was a problem with updating the ticket status. Please try again.');
                    }
            }else {
                echo json_encode('This ticket has already been used.');
            }
        } else{
            echo json_encode('This is not a valid ticket.');
        }
    }

    public function sendTicket($orderItemId){
        $ticketData = $this->orderService->createTicket($orderItemId);
        $this->emailService->sendTicketEmail($ticketData);
    }
}