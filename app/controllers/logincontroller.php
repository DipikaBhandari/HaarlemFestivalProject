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

    public function forgotPassword(){
        require __DIR__ . '/../views/Login/forgotPassword.php';
    }

    public function sendResetLink(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
            $success = $this->userService->sendResetLink($email);
            if ($success){
                require '../views/login/passwordLinkSent.php';
            }
        }
    }

    public function resetPassword(){
        $token = $_GET['token'];
        $email = $_GET['email'];
        $tokenIsValid = $this->userService->validateToken($token, $email);
        if ($tokenIsValid){
            require '../views/login/resetPassword.php';
        } else{
            require '../views/login/timedOutResetLink.php';
        }
    }

    public function updatePassword(){
        $password = isset($_POST["newPassword"]) ? htmlspecialchars($_POST["newPassword"]) : '';
        $confirmPassword = isset($_POST["confirmPassword"]) ? htmlspecialchars($_POST["confirmPassword"]) : '';
        $email = $_GET['email'];
        if ($password === $confirmPassword){
            if($this->userService->updatePassword($email, $password)){
                require '../views/login/resetSuccessful.php';
            }
        } else{
            return "The passwords don't match";
        }
    }
}