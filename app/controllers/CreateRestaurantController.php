<?php

namespace App\Controllers;

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
}