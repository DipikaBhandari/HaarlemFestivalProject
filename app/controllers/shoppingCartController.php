<?php

namespace App\Controllers;

class shoppingCartController
{
    private $ticketService;
    private $userService;
    private $orderService;
    private $emailService;

    public function __construct()
    {
        $this->ticketService = new \App\Service\ticketService();
        $this->userService = new \App\Service\userService();
        $this->orderService = new \App\Service\orderService();
        $this->emailService = new \App\Service\emailService();
    }

    public function index()
    {
        if (!isset($_SESSION)){
            session_start();
        }
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];// Start the session
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $orderId = $_SESSION['orderId'];
                $orders = $this->ticketService->getOrderByOrderId($orderId);

                foreach( $orders as $orderItem){
                    $this->ticketService->updateOrderId($orderItem, $orderId);
                }
                $this->ticketService->updateTotalPrice($orderId);
                $totalPrice = $this->ticketService->getTotalPrice($orderId);
            }
        }
        require __DIR__ . '/../views/cart/shoppingCart.php';
    }

    public function pay() {
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];
            if (isset($_POST['payNow']) && !empty($_SESSION['id'])) {
                if (!empty($_POST["amount"])) {
                    $orderId = $_SESSION['orderId'];

                    // Get payment parameters from form submission
                    $amount = number_format($_POST["amount"], 2, '.', '');
                    $description = $_POST["description"];
                    $redirectUrl = $_POST["redirectUrl"];
                    $webhookUrl = $_POST["webhookUrl"];

                    // Create Mollie payment
                    $payment = $this->ticketService->createPayment($userId, $orderId, $amount, $description, $redirectUrl, $webhookUrl);
                }
                else {
                    $totalPrice = NULL;
                }
            }
        }
    }
    public function updateQuantity()
    {
        session_start();
        $data = json_decode(file_get_contents('php://input'), true);
        $currentPrice = $this->ticketService->getOrderPriceById($data['orderItemId']);
        $this->ticketService->updateQuantity($data['orderItemId'], $data['numberOfTickets']);
        $price=null;
        if($data['eventName'] == "Yummy") {
            $price = 10;
        }
        else{
            $price = 17.5;
        }
        if($data['calculationMethod'] == 'increase'){
            $newPrice = $currentPrice + $price;
        } else {
            $newPrice = $currentPrice - $price;
        }

        $updatedPrice = $this->ticketService->updatePrice($data['orderItemId'], $newPrice);

        if($updatedPrice){
            if (isset($_SESSION['orderId'])) {
                $orderId = $_SESSION['orderId'];
                $this->ticketService->updateTotalPrice($orderId);
            }
        }
        require __DIR__ . '/../views/cart/shoppingCart.php';
    }

    public function showPaidOrders()
    {
        if (!isset($_SESSION)){
            session_start();
        }
        if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];// Start the session
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $paidOrders = $this->ticketService->PaidOrders($userId);
            }
        }
        require __DIR__ . '/../views/cart/listOfPaidOrders.php';
    }
    public function paymentRedirect()
    {
        if (isset($_GET['orderId'])) {
            $orderId = htmlspecialchars($_GET['orderId']);
            $paymentCode = $this->ticketService->getPaymentCodeByOrderId($orderId);
            $paymentStatus = $this->ticketService->getPaymentStatusFromMollie($paymentCode);
            if ($paymentStatus == "paid") {
                $this->ticketService->changePaymentToPaid($paymentCode, $orderId);
                $this->orderService->finalizeOrder($orderId);
                $this->sendTicket($orderId);
                $this->sendInvoice($orderId);
                unset($_SESSION['orderId']);
                include __DIR__ . '/../views/cart/paymentSuccessful.php';
            } else {
                include __DIR__ . '/../views/cart/paymentError.php';
            }
        }
    }

    private function sendTicket($orderId){
        try{
            $orderItems = $this->orderService->getOrderItemsIdByOrder($orderId);
            $ticketsData = [];
            foreach ($orderItems as $orderItemId) {
                $ticketData = $this->orderService->createTicket($orderItemId);
                $ticketsData[] = $ticketData;
            }

            $this->emailService->sendTicketEmail($ticketsData);
        } catch (\Exception $e) {
            error_log("An error occurred when sending the tickets: " . $e->getMessage());
        }
    }

    private function sendInvoice($orderId){
        try{
            $invoiceData = $this->orderService->createInvoice($orderId);
            $this->emailService->sendInvoiceEmail($invoiceData);
        } catch (\Exception $e) {
            error_log("An error occurred when sending the tickets: " . $e->getMessage());
        }
    }
}