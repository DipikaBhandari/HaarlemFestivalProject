<?php

namespace App\Controllers;

use App\model\user;
use Exception;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../service/UserService.php';
require_once __DIR__ . '/../service/restaurantService.php';

class ManageYummyController
{
    private $userService;
    private $userModel;
    private $restaurantService;

    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\user();
        $this->restaurantService= new \App\service\restaurantService();
    }

    public function manageYummy() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        $user = $this->userService->getUserByEmail($_SESSION['email']);
        $restaurants = $this->restaurantService->getAllYummyInfo();
        require __DIR__ . '/../views/manageYummy.php';
    }
    // In ManageYummyController.php or a new ManageRestaurantController.php

    public function manageRestaurant($restaurantId) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        // Sanitization and Validation

        try {
            // Assuming $restaurantService is already set up in the constructor like before
            $restaurantDetails = $this->restaurantService->findDetail($restaurantId);
            if (!$restaurantDetails) {
                // Handle the case where restaurant details are not found
                throw new Exception('Restaurant not found.');
            }
            $restaurantArray = [
                'restaurantId' => $restaurantId,
                'restaurantName' => $restaurantDetails->getRestaurantName(),
                'location' => $restaurantDetails->getLocation(),
                // ... add other details you want to pass to the view
            ];

            $user = $this->userService->getUserByEmail($_SESSION['email']);
            require __DIR__ . '/../views/manageRestaurant.php';

        }catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching user details: ' . $e->getMessage()]);
        }
    }
    public function updateRestaurant()
    {
        ob_start();
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        try {
            // Check if the content type is JSON
            $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
            if (stripos($contentType, 'application/json') === false) {
                throw new Exception('Content-Type is not set to JSON');
            }

            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);
            //echo 'Received the following data: ' . print_r($data, true);

            if (is_null($data)) {
                throw new Exception('JSON is null');
            }

            // Assuming $data is your decoded JSON data
            $sanitizedData = [
                'restaurantId' => filter_var($data['restaurantId'], FILTER_VALIDATE_INT),
                'restaurantName' => filter_var($data['restaurantName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'location' => filter_var($data['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
                'kidPrice' => filter_var(trim(str_replace('€', '', $data['kidPrice'])), FILTER_VALIDATE_FLOAT),
                'adultPrice' => filter_var(trim(str_replace('€', '', $data['adultPrice'])), FILTER_VALIDATE_FLOAT),
                'phoneNumber' => isset($data['phoneNumber']) ? filter_var($data['phoneNumber'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null,
                'numberOfSeats'=> filter_var($data['numberOfSeats'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ];


            $result = $this->restaurantService->updateRestaurantDetails($sanitizedData);
            header('Content-Type: application/json');
            if(!$result) {
                throw new Exception('Failed to update restaurant details');
            }
            http_response_code(200); // Success response code
           echo json_encode(['success' => true, 'message' => 'Restaurant updated successfully.']);
        }catch (Exception $e) {
           // echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            http_response_code(400);
        }
        ob_end_flush();
    }


}

