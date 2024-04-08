<?php

namespace App\Controllers;

class ticketController
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
        if(!isset($_SESSION)) {
        session_start(); // Start the session
        }

        if (isset($_SESSION['id'])) {
            // Fetch orders for the logged-in user
            $orders = $this->ticketService->getOrderItemByUserId($_SESSION['id']);

            if(!empty($_SESSION['id'])) {
                $orderItemId = $this->ticketService->getOrderItemIdByUserId($_SESSION['id']);
            }
            // Transform orders into events compatible with FullCalendar
            $events = [];
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    $year = date('Y');
                    $order['date'] = date('Y-m-d', strtotime($order['date'] . " $year"));
                    $startDateTime = $order['date'] . ' ' . $order['startTime'];
                    $endDateTime = $order['date'] . ' ' . $order['endTime'];

                    $events[] = [
                        'title' => $order['eventName'], // Add eventName to the event object
                        'status' => $order['status'],
                        'start' => date('Y-m-d\TH:i:s', strtotime($startDateTime)), // Format start time
                        'end' => date('Y-m-d\TH:i:s', strtotime($endDateTime)),     // Format end time
                        'orderItemId' => $order['orderItemId']
                    ];
                }
            } else {
                echo "No order items found.";
            }
            // Generate the sharing URL
            $sharingUrl = $this->getSharingUrl($orderItemId);

                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    $orderItems =$this->ticketService->DisplayEventsByUser($_SESSION['id']);
                }

            require __DIR__ . '/../views/wishlist/listview.php';
        } else {
            require __DIR__ . '/../views/wishlist/emptyCalendar.php';

        }
    }

    private function getSharingUrl($orderItemId)
    {
        if ($orderItemId !== null) {
            return "http://localhost/ticket?orderItemId=$orderItemId&readOnly=true";
                } else {
            return null;
        }
    }


    public function addOrder()
    {
        $orderId = null;
        if(!isset($_SESSION)){
            session_start();
        }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
                $userId = $_SESSION['id'];
                if (!isset($_SESSION['orderId'])){
                    $orderId = $this->ticketService->createNewOrderId($userId);
                    $_SESSION['orderId'] = $orderId;
                } else{
                    $orderId = $_SESSION['orderId'];
                }
                $regularTicket = $_POST["tourSingleTicket"] ?? 0;
                $familyTicket = isset($_POST["tourFamilyTicket"]) ? 4 : 0;
                $price = $regularTicket * 17.50 + $familyTicket * 15.00;
                $numberOfTickets = $regularTicket + $familyTicket;

                $event = "History Tour Event";
                $date = htmlspecialchars($_POST['date']);
                $startTime = htmlspecialchars($_POST['startTime']);
                $endTime = htmlspecialchars($_POST['endTime']);

                // Check if required fields are not empty
                if (!empty($date) && !empty($startTime) && !empty($endTime) && !empty($numberOfTickets)) {
                    // Prepare ticket data
                    $ticketData = array(
                        'regularTickets' => $regularTicket,
                        'familyTickets' => $familyTicket
                    );

                    // Encode ticket data as JSON
                    $ticketDataJson = json_encode($ticketData);

                    $newOrderItem = array(
                        'userId' => $userId,
                        'date' => $date,
                        'startTime' => $startTime,
                        'endTime' => $endTime,
                        'eventName' => $event,
                        'numberOfTickets' => $numberOfTickets,
                        'price' => $price,
                        'orderId' => $orderId,
                        'ticketData' => $ticketDataJson // Store ticket data as JSON string
                    );

                    // Attempt to create the order
                    $order = $this->ticketService->createOrderItem($newOrderItem);
                    if ($order) {
                        // Update the order table with the total price
                        $this->ticketService->updateTotalPrice($orderId);
                        echo json_encode(['success' => true, 'message' => 'Order created successfully', 'order' => $newOrderItem]);
                    } else {
                        // Return error response if order creation failed
                        echo json_encode(['error' => 'Failed to create order. Please try again.']);
                    }
                } else {
                    // Return error response if required fields are empty
                    echo json_encode(['error' => 'Missing or empty required fields']);
                }
            }
        }

    public function deleteOrder(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Delete the order from the database
        $this->ticketService->deleteOrderbyOrderId($data['orderItemId']);

        require __DIR__ . '/../views/wishlist/listview.php';
    }
}