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

    public function forgotPassword(){
        require __DIR__ . '/../views/Login/forgotPassword.php';
    }

    public function sendResetLink(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
            $success = $this->userService->sendResetLink($email);
            $response = [];
            if ($success){
                $response['success'] = true;
                $response['message'] = "We have sent a reset link to your email address.";
            }
            else{
                $response['success'] = false;
                $response['message'] = "There has been a problem with sending your reset link. Please try again later.";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
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
        $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
        $response = [];
        if ($password === $confirmPassword){
            if($this->userService->updatePassword($email, $password)){
                $response['success'] = true;
                $response['message'] = "Password updated successfully";
            } else{
                $response['success'] = false;
                $response['message'] = "Error updating password";
            }
        } else{
            $response['success'] = false;
            $response['message'] = "The passwords don't match";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}