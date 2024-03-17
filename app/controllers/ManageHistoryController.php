<?php

namespace App\Controllers;



use App\model\user;


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../service/UserService.php';
class ManageHistoryController
{
    private $userService;
    private $userModel;


    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\user();

    }

    public function manageHistory()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userService->getUserByEmail($_SESSION['email']);
        $users = $this->userService->fetchAllUsers();
        require __DIR__ . '/../views/manageHistory.php';
    }
}

