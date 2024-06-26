<?php

namespace App\Controllers;



use App\model\Roles;
use App\service\userService;


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
        try{
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
                $success = $this->userService->sendResetLink($email);
                $response = [];
                if ($success) {
                    $response['success'] = true;
                    $response['message'] = "We have sent a reset link to your email address.";
                } else {
                    $response['success'] = false;
                    $response['message'] = "There has been a problem with sending your reset link. Please try again later.";
                }
            }
        } catch (\Exception $e) {
            error_log('Error sending reset link: ' . $e->getMessage());
            $response['success'] = false;
            $response['message'] = "An error occurred while sending the reset link.";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function resetPassword(){
        $token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';
        $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
        try{
            $tokenIsValid = $this->userService->validateToken($token, $email);
            if ($tokenIsValid){
                require '../views/login/resetPassword.php';
            } else{
                require '../views/login/timedOutResetLink.php';
            }
        } catch(\Exception $e){
            error_log('Error validating password reset token: ' . $e->getMessage());
        }
    }

    public function updatePassword()
    {
        $response = [];
        try{
            $password = isset($_POST["newPassword"]) ? htmlspecialchars($_POST["newPassword"]) : '';
            $confirmPassword = isset($_POST["confirmPassword"]) ? htmlspecialchars($_POST["confirmPassword"]) : '';
            $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';

            if ($password === $confirmPassword) {
                if ($this->userService->updatePassword($email, $password)) {
                    $response['success'] = true;
                    $response['message'] = "Password updated successfully";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error updating password";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "The passwords don't match";
            }
        } catch(\Exception $e) {
            error_log('Error updating password: ' . $e->getMessage());
            $response['success'] = false;
            $response['message'] = "An error occurred while updating the password.";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function login()
    {
        if(!isset($_SESSION)){
            session_start();
        }

        if (isset($_POST["btnLogin"]) && isset($_POST["username"]) && isset($_POST["password"])) {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);
            $loggedUser = $this->userService->authenticateUser($username, $password);

            if ($loggedUser) {
                // Start the session and store user information
                $_SESSION['username'] = $loggedUser->getUsername();
                $_SESSION['email'] = $loggedUser->getEmail();
                $_SESSION['role'] = $loggedUser->getRole();
                $_SESSION['id'] = $loggedUser->getUserId();

                // Redirect to the festival index page
                header("Location: /home");
                               // require __DIR__ . '/../views/home/index.php';
                exit(); // Ensure that no further code is executed after redirection
            }
        }

        // If not logged in or form not submitted, show login form
        require_once __DIR__ . '/../views/Login/login.php';
    }




    public function register()
    {
        $errorMessage = "";
        if (isset($_POST["registerBtn"])) {
            if (empty($_POST["username"])) {
                $errorMessage = "Please fill out your first name";
            }
            else if (empty($_POST["email"])) {
                $errorMessage = "Please fill out your email";
            } else if (empty($_POST["password"])) {
                $errorMessage = "Please fill out your password";
            } else {
                if ($this->userService->captchaVerification($errorMessage)) {

                    $this->createNewUser();
                }
            }
        }
        require __DIR__ . '/../views/Login/registeruser.php';
    }

    public function createNewUser():void
    {
        if (isset($_POST["registerBtn"])) {
            // Validate and sanitize user inputs
            $username = htmlspecialchars($_POST["username"]);
            $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ? htmlspecialchars($_POST["email"]) : null;
            $phonenumber = htmlspecialchars($_POST["phonenumber"]);
            $address = htmlspecialchars($_POST["address"]);
            $password = htmlspecialchars($_POST["password"]);
            $picture = $_FILES['createUserImage']; // Handle file upload securely
            $role = Roles::customer();

            // Ensure required fields are not empty
            if (!empty($username) && $email !== null && !empty($phonenumber) && !empty($password) && !empty($picture)) {
                $newUser = array(
                    "username" => $username,
                    "email" => $email,
                    "phonenumber" => $phonenumber,
                    "address" => $address,
                    "password" => $password,
                    "picture" => $picture,
                    "role" => $role
                );
                if (empty($_SESSION['orderId'])) {
                    $orderId = null;
                } else {
                    $orderId = $_SESSION['orderId'];
                }
                $registrationSuccess = $this->userService->registered($newUser);

                if ($registrationSuccess) {
                    // Redirect to login page after successful registration
//                    header("Location: /login/login");
                    echo "<script>window.location.replace('/home');</script>";

                    exit();
                } else {
                    // Registration failed, show the registration form again with an error message
                    $_SESSION['registration_error'] = "Registration failed. Please try again.";
                }
            } else {
                // Invalid or missing input data, show the registration form again with an error message
                $_SESSION['registration_error'] = "Please fill out all required fields correctly.";
            }
        }
    }
    public function logout(){
        $_SESSION = array();
        session_destroy();

        header("Location: /home");
        exit();
    }
}