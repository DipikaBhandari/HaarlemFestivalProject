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
        // Assuming error reporting is set correctly elsewhere in your application
        try {
            // Verify this is a POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method. Only POST is allowed.');
            }

            // Process form data
            $sanitizedData = [
                'restaurantId' => filter_input(INPUT_POST, 'restaurantId', FILTER_VALIDATE_INT),
                'restaurantName' => filter_input(INPUT_POST, 'restaurantName', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'location' => filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'kidPrice' => filter_var(trim(str_replace('€', '', $_POST['kidPrice'])), FILTER_VALIDATE_FLOAT),
                'adultPrice' => filter_var(trim(str_replace('€', '', $_POST['adultPrice'])), FILTER_VALIDATE_FLOAT),
                'phoneNumber' => filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'numberOfSeats' => filter_input(INPUT_POST, 'numberOfSeats', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'foodOfferings' => filter_input(INPUT_POST, 'foodOfferings', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ];

            // Handle file upload if provided
            if (isset($_FILES['restaurantImage']) && $_FILES['restaurantImage']['error'] === UPLOAD_ERR_OK) {
                $sanitizedData['restaurantImage'] = $this->handleFileUpload($_FILES['restaurantImage']);
            } else {
                // Fallback or error handling for missing image
                $sanitizedData['restaurantPicture'] = $_POST['currentImagePath'] ?? null; // Or handle appropriately
            }


            // Update the restaurant details in the database
            $result = $this->restaurantService->updateRestaurantDetails($sanitizedData);
            if(!$result) {
                throw new Exception('Failed to update restaurant details');
            }

            // Respond with JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Restaurant updated successfully.']);
            http_response_code(200); // Success response code
        } catch (Exception $e) {
            http_response_code(400); // Bad Request or appropriate status code
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        ob_end_flush();
    }

    public function delete(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the raw POST data
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);

            $restaurantId = $data['restaurantId'] ?? null;

            if ($restaurantId) {
                $result = $this->restaurantService->deleteRestaurant($restaurantId);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Restaurant deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete restaurant']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => 'Restaurant ID is missing']);
            }
        }
    }
    private function handleFileUpload($file)
    {
        // Check for errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload error number: {$file['error']}");
        }

        // Verify the file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($file['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Invalid file type.");
        }

        $targetDir = __DIR__ . '/../public/img/';
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $safeFilename = bin2hex(random_bytes(16)) . '.' . $fileExtension;
        $targetFile = $targetDir . $safeFilename;

        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            throw new Exception("Failed to move uploaded file.");
        }

        return '../img/' . $safeFilename; // Return the path relative to the public directory
    }


}

