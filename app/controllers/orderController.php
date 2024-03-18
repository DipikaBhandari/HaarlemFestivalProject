<?php

namespace App\Controllers;

use App\service\qrCodeService;

class orderController
{
    private $orderService;
    private $qrCodeService;

    public function __construct()
    {
        $this->orderService = new \App\Service\orderService();
        $this->qrCodeService = new \App\Service\qrCodeService();
    }

    public function createOrder()
    {
        //create qrhash
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
}