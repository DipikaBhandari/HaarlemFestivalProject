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
                $orders = $this->ticketService->getOrderByUserId($userId);

                $totalPrice = $this->ticketService->getTotalPrice($userId);

            }
//            $this->userService->createNewOrder($userId);
            if (isset($_POST['payNow']) && !empty($_SESSION['id'])) {

                if (!empty($_POST["amount"])) {
                    $orderId = $this->ticketService->createNewOrderId($userId);
                    var_dump($orderId);
                    //$orderId = $this->ticketService->getOrderIdByCustomerId($userId);
                    $this->ticketService->updateOrderId($userId, $orderId);
                    // Get payment parameters from form submission
                    $amount = number_format($_POST["amount"], 2, '.', '');
                    $description = $_POST["description"];
                    $redirectUrl = $_POST["redirectUrl"];
                    $webhookUrl = $_POST["webhookUrl"];

                    // Create Mollie payment
                    $payment = $this->ticketService->createPayment($userId, $orderId, $amount, $description, $redirectUrl, $webhookUrl);

                }
            } else {
                // Handle the case where amount is not set or empty
                // For example, display an error message or redirect back to the form
                echo "Error: Amount is missing or empty.";
            }
        }

        require __DIR__ . '/../views/cart/shoppingCart.php';
    }

    public function updateQuantity()
    {
        session_start();
        $data = json_decode(file_get_contents('php://input'), true);
        $this->ticketService->updateQuantity($data['orderItemId'], $data['numberOfTickets']);

        $currentPrice = $this->ticketService->getOrderPriceById($data['orderItemId']);
        $additionalPricePerTicket = 17.5;

        $newPrice = $currentPrice + ($data['numberOfTickets'] * $additionalPricePerTicket);
        $updatedPrice = $this->ticketService->updatePrice($data['orderItemId'], $newPrice);

        if($updatedPrice){
            if (isset($_SESSION['id'])) {
                $userId = $_SESSION['id'];
                $this->ticketService->updateTotalPrice($userId);
            }
        }
//        if (isset($_SESSION['id'])) {
//            $userId = $_SESSION['id'];
//            $this->updateOrderPrice($userId, $updatedPrice);
//            $totalPrice = $this->ticketService->getTotalPrice($userId);
//            echo json_encode(['success' => true, 'totalPrice' => $totalPrice]);
//        } else {
//            // Handle the case where updating the price or quantity fails
//            echo json_encode(['success' => false, 'message' => 'Failed to update price or quantity']);
//        }

        require __DIR__ . '/../views/cart/shoppingCart.php';

    }

    public function updateOrderPrice($userId, $updatedPrice)
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $totalPrice = $this->ticketService->getTotalPrice($userId); // Assuming there's a method to retrieve total price
            $newTotalPrice = $totalPrice + $updatedPrice;
            $this->ticketService->updateOrderPrice($newTotalPrice, $userId);
        }
    }
    public function showPaidOrders()
    {     session_start();
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
                    include __DIR__ . '/../views/cart/paymentSuccessful.php';
                } else {
                    include __DIR__ . '/../../views/ShoppingCart/paymentError.php.php';
                }
            }
    }




    public function deleteOrderItem()
    { session_start();
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];// Start the session
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $orderItemId = $_POST['orderItemId'];
                $orderId = $this->ticketService->getOrderIdByCustomerId($userId);
                $this->ticketService->deleteOrderbyOrderId($orderItemId);
                $this->ticketService->updateTotalPrice($orderId);

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