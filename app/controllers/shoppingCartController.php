<?php

namespace App\Controllers;

class shoppingCartController
{

    private $ticketService;
    private $userService;

    public function __construct()
    {
        $this->ticketService = new \App\Service\ticketService();
        $this->userService = new \App\Service\userService();
    }

    public function index()
    {
        session_start();
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];// Start the session

            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $orders = $this->ticketService->getOrderByUserId($userId);
                var_dump($orders);
                $totalPrice = $this->ticketService->getTotalPrice($userId);

            }
            $this->userService->createNewOrder($userId);
            if (isset($_POST['payNow']) && !empty($_SESSION['id'])) {

                    if (!empty($_POST["amount"])) {
                        $orderId = $this->ticketService->getOrderIdByCustomerId($userId);
                        // Get payment parameters from form submission
                        $amount = number_format($_POST["amount"], 2, '.', '');
                        $description = $_POST["description"];
                        $redirectUrl = $_POST["redirectUrl"];
                        $webhookUrl = $_POST["webhookUrl"];

                        // Create Mollie payment
                        $payment=$this->ticketService->createPayment($userId, $orderId, $amount, $description, $redirectUrl, $webhookUrl);
                        if($payment){
                            $this->ticketService->updateOrderItemStatus('paid', $orderId, $userId);
                        }
                    } else {
                        // Handle the case where amount is not set or empty
                        // For example, display an error message or redirect back to the form
                        echo "Error: Amount is missing or empty.";
                    }

            }
        }
        require __DIR__ . '/../views/cart/shoppingCart.php';
    }

    public function paymentRedirect()
    {

            if (isset($_GET['orderId'])) {
                $orderId = htmlspecialchars($_GET['orderId']);
                $paymentCode = $this->ticketService->getPaymentCodeByOrderId($orderId);
                $paymentStatus = $this->ticketService->getPaymentStatusFromMollie($paymentCode);
                if ($paymentStatus == "paid") {
                    $this->ticketService->changePaymentToPaid($paymentCode, $orderId);
                    include __DIR__ . '/../views/cart/paymentSuccessful.php';
                } else {
                    include __DIR__ . '/../../views/ShoppingCart/paymentError.php.php';
                }
            }

    }
}