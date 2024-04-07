<?php

namespace App\Controllers;



use App\model\reservation;
use App\model\user;
use App\service\restaurantService;
use Exception;


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/reservation.php';

require_once __DIR__ . '/../service/UserService.php';
require_once __DIR__ . '/../service/reservationService.php';
require_once __DIR__ . '/../service/restaurantService.php';

class ManageReservationController
{
    private $userService;
    private $userModel;
    private $reservationService;
    private $restaurantService;

    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\user();
        $this->reservationService= new \App\service\reservationService();
        $this->restaurantService = new restaurantService();
    }
    public function manageReservation()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userService->getUserByEmail($_SESSION['email']);
        $getAllRestaurantSections =$this->restaurantService->getAllYummyInfo();
        $reservationDetails = $this->reservationService->getReservationDetails();
        require __DIR__ . '/../views/manageReservation.php';
    }
    public function getSingleReservationDetails(){
        $orderItemId = $_GET['orderItemId'] ?? '';
        if (!$orderItemId) {
            http_response_code(400);
            echo json_encode(['error' => '$orderItemId is required']);
            return;
        }
        try {
            $reservationDetails = $this->reservationService->getSingleReservationDetails($orderItemId);
            if ($reservationDetails) {
                echo json_encode($reservationDetails);
                return;
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Reservation not found']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching reservation details: ' . $e->getMessage()]);
        }
    }
    public function addReservation()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        header('Content-Type: application/json');

        $rawData = file_get_contents('php://input');
        error_log($rawData); // This will log the raw data for debugging purposes.
        $reservationDetails = json_decode($rawData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Handle the error, for example:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data provided']);
            return;
        }
        if (!$this->validateData($reservationDetails)) {
            http_response_code(400);
            echo json_encode(['error' => 'Validation failed for reservation data.']);
            return;
        }
        $userId = $_SESSION['id'];

        $reservation = new reservation();
        $reservation->setEventName($reservationDetails['eventName']);
        $reservation->setDate($reservationDetails['date']);
        $reservation->setStartTime($reservationDetails['startTime']);
        $reservation->setEndTime($reservationDetails['endTime']);
        $reservation->setSpecialRequest($reservationDetails['specialRequest'] ?? null);
        $reservation->setNumberOfTickets($reservationDetails['numberOfTickets']);
        $reservation->setPrice($reservation->calculatePrice());

        $reservation->setStatus($reservationDetails['status']);
        $reservation->setRestaurantSectionId($reservationDetails['restaurantSectionId']);
        $reservation->setUserId($userId);

        try {
            $result = $this->reservationService->addNewReservation($reservation);
            echo json_encode(['success' => true, 'message' => 'Reservation successfully added.', 'id' => $result]);
        } catch (Exception $e) {
            // Correct the HTTP status code and the response structure to maintain consistency
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add reservation.', 'exception' => $e->getMessage()]);
        }
    }
    private function validateData($data)
    {
        return isset(
                $data['eventName'],
                $data['date'],
                $data['startTime'],
                $data['endTime'],
                $data['numberOfTickets'],
                //$data['price'],
                $data['status'],
                $data['restaurantSectionId']
            ) && is_numeric($data['restaurantSectionId']) && is_numeric($data['numberOfTickets']) ;
    }

    public function updateReservationDetails() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Perform validation on $data here

        // Update the reservation
        $result = $this->reservationService->updateReservationDetails($data);

        // Send a JSON response back to the client
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Reservation updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update reservation']);
        }
    }
    public function deactivateReservation() {
        $orderItemId = $_GET['orderItemId'] ?? null;
        if (!$orderItemId) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Reservation ID is required']);
            exit;
        }

        // Call the service method to update the reservation status
        $result = $this->reservationService->deactivateReservation($orderItemId);

        // Send a JSON response back to the client
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Reservation deactivated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to deactivate reservation']);
        }
    }
}