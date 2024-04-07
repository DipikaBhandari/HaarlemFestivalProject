<?php

namespace App\Controllers;


class orderController
{
    private $orderService;
    private $emailService;
    public function __construct()
    {
        $this->orderService = new \App\Service\orderService();
        $this->emailService = new \App\service\emailService();
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
}