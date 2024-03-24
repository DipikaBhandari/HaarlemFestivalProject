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
                            'message' => 'Ticket is valid.'
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
}