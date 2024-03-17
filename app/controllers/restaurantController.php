<?php

namespace App\Controllers;

use App\model\user;
use App\service\restaurantService;
use App\service\userService;
use Exception;

class restaurantController
{
    private $userService;
    private $restaurantService;
    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->restaurantService = new restaurantService();
        ob_start();

    }
    public function YummyHome(){
        $sections = $this->restaurantService->getSectionsByPage(3);
        //$headerSection = $this->restaurantService->getSectionByType('header', 2);
        //$introductionSection = $this->restaurantService->getSectionByType('introduction', 2);

        foreach ($sections as $key => $section) {
            $sections[$key]['images'] = $this->restaurantService->getImageBySection($section['sectionId']);
            $sections[$key]['paragraphs'] = $this->restaurantService->getParagraphsBySection($section['sectionId']);
            $sections[$key]['card'] = $this->restaurantService->getCardItemsBySection($section['sectionId']);
        }
        $locations = $this->restaurantService->getAllYummyLocations();
        $restaurantName = $this->restaurantService->getAllYummyInfo();

        require __DIR__ .'/../views/yummy/YummyHome.php';
    }
    public function details($restaurantId)
    {
        // Fetch details for the specific restaurant
        $restaurantDetails = $this->restaurantService->getRestaurantDetails($restaurantId);
        if ($restaurantDetails) {

            $sections = $this->restaurantService->getSectionsForRestaurant($restaurantId);
            foreach ($sections as $key => $section) {

                //$sections[$key]['Yummy'] = $this->restaurantService->getRestaurantDetails($section['restaurantSectionId']);
                $sections[$key]['paragraphs'] = $this->restaurantService->getYummyParagraphsBySection($section['restaurantSectionId']);
                $sections[$key]['OpeningTime'] = $this->restaurantService->getYummyOpeningBySection($section['restaurantSectionId']);


                //$sections[$key]['card'] = $this->restaurantService->getCardItemsBySection($section['restaurantSectionId']);
            }
            // Pass the restaurant details and sections to the view
            require __DIR__ . '/../views/yummy/details.php';
        }
        else{
            // Handle not found
            http_response_code(404);
            echo "Restaurant not found";
            return;
        }
    }
    public function getSessionsForRestaurant($restaurantId) {
        try {
            $sessions = $this->restaurantService->getSessionsForRestaurantId($restaurantId);
            echo json_encode($sessions);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function create(){

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

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
                'userId' => $_SESSION['id'],
                'session' => $_POST['session'],
                'num_adults' => $_POST['numAdults'],
                'num_children' => $_POST['numChildren'],
                'date' => $_POST['date'],
                'price' => 10 * $totalPeople,
                'special_requests' => $_POST['specialRequests'] ?? '',
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
        ob_end_flush();
    }
}
