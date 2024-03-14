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
        if (isset($_SESSION['userId'])) {
            // Fetch orders for the logged-in user
            $orders = $this->ticketService->getOrderByUserId($_SESSION['userId']);

            // Transform orders into events compatible with FullCalendar
            $events = [];
            foreach ($orders as $order) {
                $events[] = [
                    'title' => $order['eventName'],
                    'start' => $order['date'] . ' ' . $order['startTime'],
                    'end' => $order['date'] . ' ' . $order['endTime']
                ];
            }

            // Pass events to the view
            require __DIR__ . '/../views/wishlist/listview.php';
        } else {
            // Handle case where user is not logged in or session data is not set
            // Redirect to login page or display an error message
            echo "User is not logged in or session data is not set.";
        }
    }



    public function addOrder()
    {
        // Check if it's a POST request and required fields are set
//        if isset($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eventName'], $_POST['date'], $_POST['startTime'], $_POST['endTime'], $_POST['numberOfTickets'])) {
        // Retrieve ticket information from the AJAX request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve ticket information from the AJAX request
            if (isset($_POST['eventName'], $_POST['date'], $_POST['startTime'], $_POST['endTime'], $_POST['numberOfTickets'])) {
                $eventName = $_POST['eventName'];
                $date = $_POST['date'];
                $startTime = $_POST['startTime'];
                $endTime = $_POST['endTime'];
                $numberOfTickets = $_POST['numberOfTickets'];

                error_log("Received data: " . print_r($_POST, true));
                // Check if required fields are not empty
                if (!empty($eventName) && !empty($date) && !empty($startTime) && !empty($endTime) && !empty($numberOfTickets)) {
                    $newOrderItem = array(
                        'eventName' => $eventName,
                        'date' => $date,
                        'startTime' => $startTime,
                        'endTime' => $endTime,
                        'numberOfTickets' => $numberOfTickets
                    );

                    // Attempt to create the order
                    $order = $this->ticketService->createOrder($newOrderItem);

                    // Check if order creation was successful
                    if ($order) {
                        // Redirect to home page after successful order creation
                        echo json_encode(['success' => true, 'message' => 'Order created successfully']);
                        exit;
                    } else {
                        // Return error response if order creation failed
                        echo json_encode(['error' => 'Failed to create order. Please try again.']);
                        exit;
                    }
                } else {
                    // Return error response if required fields are empty
                    echo json_encode(['error' => 'Missing or empty required fields']);
                    exit;
                }
            } else {
                // Return error response for invalid request method or missing fields
                echo json_encode(['error' => 'Invalid request']);
                exit;
            }
        }
    }

}