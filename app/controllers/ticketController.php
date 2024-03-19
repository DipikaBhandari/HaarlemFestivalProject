<?php

namespace App\Controllers;

class ticketController
{
    private $ticketService;

    public function __construct()
    {
        $this->ticketService = new \App\Service\ticketService();
    }

    public function index()
    {
        session_start(); // Start the session
        if (isset($_SESSION['id'])) {
            // Debugging statement to check the value of $_SESSION['id']
            var_dump($_SESSION['id']);

            // Fetch orders for the logged-in user
            $orders = $this->ticketService->getOrderByUserId($_SESSION['id']);

            // Fetch orderItemId if it's not already fetched

            if( !empty($_SESSION['id'])) {
                $orderItemId = $this->ticketService->getOrderIdByUserId($_SESSION['id']);
            }

            // Debugging statement to inspect the contents of $orders array
            var_dump($orders);

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

            // Pass events and sharing URL to the view
            require __DIR__ . '/../views/wishlist/listview.php';
        } else {
            echo "User is not logged in or session data is not set.";
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
        session_start();

        // Check if it's a POST request and required fields are set
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {

            if (isset($_POST["tourFamilyTicket"])) {
//                $tourType = "family";
                $numberOfTickets = 4;
            } else {
//                $tourType = "single";
                $numberOfTickets = $_POST["tourSingleTicket"];
            }

            // Retrieve ticket information from the AJAX request
            $event= "History Tour Event";
            $userId = $_SESSION['id'];
            $date = htmlspecialchars($_POST['date']);
            $startTime = htmlspecialchars($_POST['startTime']);
            $endTime = htmlspecialchars($_POST['endTime']);
          //  $numberOfTickets = htmlspecialchars($_POST['numberOfTickets']);

            // Check if required fields are not empty
            if (!empty($date) && !empty($startTime) && !empty($endTime) && !empty($numberOfTickets)) {
                $newOrderItem = array(
                    'userId' =>  $userId, // Include the userId in the order data
                    'date' => $date,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'eventName' => $event,
                    'numberOfTickets' => $numberOfTickets
                );

                // Attempt to create the order
                $order = $this->ticketService->createOrder($newOrderItem);

                // Check if order creation was successful
                if ($order) {
                    // Redirect to home page after successful order creation
                    echo json_encode(['success' => true, 'message' => 'Order created successfully']);
                } else {
                    // Return error response if order creation failed
                    echo json_encode(['error' => 'Failed to create order. Please try again.']);
                }
            } else {
                // Return error response if required fields are empty
                echo json_encode(['error' => 'Missing or empty required fields']);
            }
        } else {
            // Return error response if userId is not set in session
            echo json_encode(['error' => 'User not authenticated']);
        }
        exit;
    }


    public function deleteOrder(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
//        var_dump($data);
//        die();

        // Delete the order from the database
        $this->ticketService->deleteOrderbyOrderId($data['orderItemId']);

        require __DIR__ . '/../views/wishlist/listview.php';
    }


}