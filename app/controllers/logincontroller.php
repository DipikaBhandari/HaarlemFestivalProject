<?php

namespace App\Controllers;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../service/UserService.php';
class logincontroller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new \App\Service\userService();
    }

    public function login()
    {
        require __DIR__ . '/../views/Login/login.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);
            $loggedUser= $this->userService->authenticateUser($username, $password);
            if($loggedUser){
                header("Location: home/what");
                exit;
            } else {
                $loginError = "Invalid username or password";
                $pageTitle = "Login";
                require '../views/loginUser/login.php';
            }
        }
    }
}