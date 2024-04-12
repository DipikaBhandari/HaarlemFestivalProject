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
//    private function handleFileUpload($file)
//    {
//        // Check for errors
//        if ($file['error'] !== UPLOAD_ERR_OK) {
//            throw new Exception("File upload error number: {$file['error']}");
//        }
//
//        // Verify the file is an image
//        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
//        $fileType = mime_content_type($file['tmp_name']);
//
//        if (!in_array($fileType, $allowedTypes)) {
//            throw new Exception("Invalid file type.");
//        }
//
//        $targetDir = __DIR__ . '/../public/img/';
//        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
//        $safeFilename = bin2hex(random_bytes(16)) . '.' . $fileExtension;
//        $targetFile = $targetDir . $safeFilename;
//
//        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
//            throw new Exception("Failed to move uploaded file.");
//        }
//
//        return '../img/' . $safeFilename; // Return the path relative to the public directory
//    }

    public function updateRestaurant()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            exit('Invalid request method. Only POST is allowed.');
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }

        try {
            $restaurantId = $_POST['restaurantId'] ?? null;
            $sanitizedData = $this->sanitizeInput($_POST);
            $fileData = $_FILES['restaurantImage'] ?? null;

            if ($fileData && $fileData['error'] === UPLOAD_ERR_OK) {
                $sanitizedData['restaurantPicture'] = $this->handleFileUpload($fileData);
            } else {
                $sanitizedData['restaurantPicture'] = $_POST['currentImagePath'] ?? null;
            }

            $result = $this->restaurantService->updateRestaurantDetails($restaurantId, $sanitizedData);
            if (!$result) {
                error_log('No rows were updated. Data may be identical or restaurantId not found.');
                // Include more detailed information in development environment only
                $detailedMessage = 'Failed to update restaurant details. No rows were affected.';
                throw new Exception($detailedMessage);
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Restaurant updated successfully.']);
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function sanitizeInput($data)
    {
        // Perform your sanitation here. This is just an example.
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedData[$key] = htmlspecialchars(strip_tags(trim($value)));
        }
        return $sanitizedData;
    }


    private function handleFileUpload($fileData)
    {
        // The absolute path where the image will be stored on the server
        $targetDir = __DIR__ . '/../public/img/'; // Adjust the path as needed
        $safeFilename = preg_replace('/\s+/', '_', $fileData['name']); // Replace spaces with underscores
        $targetFile = $targetDir . $safeFilename;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($fileData['tmp_name']);
        if ($check === false) {
            throw new Exception("File is not an image.");
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            throw new Exception("Sorry, file already exists.");
        }

        // Check file size
        if ($fileData['size'] > 500000) { // example size limit 500 KB
            throw new Exception("Sorry, your file is too large.");
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Make sure the target directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Try to upload file
        if (!move_uploaded_file($fileData['tmp_name'], $targetFile)) {
            throw new Exception("Sorry, there was an error uploading your file.");
        }

        // Return the relative path as it should be saved in the database
        return '../img/' . $safeFilename; // Adjust the relative path as needed
    }

}

