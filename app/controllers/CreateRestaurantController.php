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

            if (!isset($_SESSION['email'])) {
                throw new Exception("User not logged in");
            }

            // Validate that the request is a POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method. Please use POST.');
            }
            // Handle File Upload
            $imagePath = $this->handleFileUpload();

            // Collect and sanitize form data
            $sanitizedData = $this->sanitizeRestaurantData($_POST);
            $sanitizedData['imagePath'] = $imagePath;

            // Create new restaurant
            $result = $this->restaurantService->createNewRestaurant($sanitizedData);
            if (!$result['success']) {
                throw new Exception('Failed to add restaurant: ' . $result['message']);
            }
            echo json_encode(['success' => true, 'message' => 'New restaurant created successfully.']);

        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } finally {
            ob_end_flush();
        }
    }
    private function handleFileUpload() {
        if (isset($_FILES['restaurantImage']) && $_FILES['restaurantImage']['error'] == UPLOAD_ERR_OK) {
            // Verify the file is an image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['restaurantImage']['type'];

            if (in_array($fileType, $allowedTypes)) {
                $targetDir = __DIR__ . '/../public/img/';
                $fileExtension = strtolower(pathinfo($_FILES['restaurantImage']['name'], PATHINFO_EXTENSION));
                $safeFilename = bin2hex(random_bytes(16)) . '.' . $fileExtension;
                $targetFile = $targetDir . $safeFilename;

                if (move_uploaded_file($_FILES['restaurantImage']['tmp_name'], $targetFile)) {
                    return '../img/' . $safeFilename; // Return the path relative to the public directory
                } else {
                    throw new Exception("Failed to move uploaded file.");
                }
            } else {
                throw new Exception("Invalid file type.");
            }
        } else {
            throw new Exception("No file uploaded or upload error.");
        }
    }

    private function sanitizeRestaurantData($data) {
        return [
            'sectionId' => 14, // Assuming this is preset or static for now
            'restaurantName' => filter_var($data['restaurantName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'location' => filter_var($data['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'phoneNumber' => isset($data['phoneNumber']) ? filter_var($data['phoneNumber'], FILTER_SANITIZE_NUMBER_INT) : null,
            'kidPrice' => isset($data['kidPrice']) ? $this->sanitizePrice($data['kidPrice']) : null,
            'adultPrice' => isset($data['adultPrice']) ? $this->sanitizePrice($data['adultPrice']) : null,
            'numberOfSeats' => isset($data['numberOfSeats']) ? filter_var($data['numberOfSeats'], FILTER_SANITIZE_NUMBER_INT) : null,
            // Add the new fields
            'description' => isset($data['description']) ? filter_var($data['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '',
            'foodOfferings' => isset($data['foodOfferings']) ? filter_var($data['foodOfferings'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '',
        ];
    }

    private function sanitizePrice($price) {
        $price = str_replace(['€', '$', ','], '', $price); // Remove currency symbols and commas
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return $price;
    }
}
