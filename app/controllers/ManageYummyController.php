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

}

