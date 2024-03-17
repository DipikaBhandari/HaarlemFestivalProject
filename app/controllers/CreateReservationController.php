<?php

namespace App\Controllers;
use App\service\restaurantService;
use Exception;

class CreateReservationController
{
    private $restaurantService;
    public function __construct()
    {
        $this->restaurantService = new restaurantService();
    }
    public function create(){
        session_start();



        var_dump($_POST);
        if (!isset($_POST['restaurant'], $_POST['numAdults'], $_POST['numChildren'], $_POST['date'], $_POST['session'])) {
            //http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Missing fields.']);
            return;
        }

        try{
            $sessionDetails = $this->restaurantService->getSessionById($_POST['session']);
            if (!$sessionDetails) {
                throw new Exception('Session does not exist.');
            }

            $totalPeople = $_POST['numAdults'] + $_POST['numChildren'];
            $this->restaurantService->updateSessionSeats($_POST['session'], $totalPeople);

            $reservationData = [
                'userId' => $_SESSION['id'] ,
                'session' => $_POST['session'],
                'num_adults' => $_POST['numAdults'],
                'num_children' => $_POST['numChildren'],
                'date' => $_POST['date'],
                'price' => 10 * $totalPeople,
                'special_requests' => $_POST['specialRequests'],
                'restaurantSectionId' => $_POST['restaurant'],
            ];

            $result = $this->restaurantService->createReservation($reservationData);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Reservation created successfully']);
            } else {
                throw new Exception('Reservation could not be created');
            }

        } catch (Exception $e) {
            http_response_code(400); // Set appropriate HTTP response code
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    }
}
