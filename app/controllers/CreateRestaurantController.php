<?php

namespace App\Controllers;

use Exception;

class CreateRestaurantController
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

    public function CreateRestaurant(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        $user = $this->userService->getUserByEmail($_SESSION['email']);
        //
        require __DIR__ . '/../views/createRestaurant.php';
    }
    public function create()
    {

        ob_start();
        try {
            $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
            if (stripos($contentType, 'application/json') === false) {
                throw new Exception('Content-Type is not set to JSON');
            }

            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);

            if (!$data) {
                throw new Exception('Request body is empty');
            }

            $sanitizedData = $this->sanitizeRestaurantData($data);
            $result = $this->restaurantService->createNewRestaurant($sanitizedData);
            if($result['success']) {
                echo json_encode(['success' => true, 'message' => 'New restaurant created successfully.']);
            }else {
                throw new Exception('Failed to add restaurant: ' . $result['message']);
            }
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        ob_end_flush();
    }
    private function sanitizeRestaurantData($data) {
        return [
            'sectionId' => 14,
            'restaurantName' => filter_var($data['restaurantName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'location' => filter_var($data['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'phoneNumber' => isset($data['phoneNumber']) ? filter_var($data['phoneNumber'], FILTER_SANITIZE_NUMBER_INT) : null,
            'kidPrice' => isset($data['kidPrice']) ? $this->sanitizePrice($data['kidPrice']) : null,
            'adultPrice' => isset($data['adultPrice']) ? $this->sanitizePrice($data['adultPrice']) : null,
            'numberOfSeats' => isset($data['numberOfSeats']) ? filter_var($data['numberOfSeats'], FILTER_SANITIZE_NUMBER_INT) : null,
            ];
    }

    private function sanitizePrice($price) {
        $price = str_replace(['€', '$', ','], '', $price); // Remove currency symbols and commas
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return $price;
    }

}
