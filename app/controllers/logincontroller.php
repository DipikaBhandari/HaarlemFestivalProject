<?php

namespace App\Controllers;

use App\model\Roles;
use App\service\userService;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../service/UserService.php';
class logincontroller
{
    private userService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login()
    {
        // Start session
        session_start();

        if (isset($_POST["btnLogin"]) && isset($_POST["username"]) && isset($_POST["password"])) {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);
            $loggedUser = $this->userService->authenticateUser($username, $password);

            if ($loggedUser) {
                // Start the session and store user information
                $_SESSION['username'] = $loggedUser->getUsername();

                // Redirect to the festival index page
                require __DIR__ . '/../views/festival/index.php';
                exit(); // Ensure that no further code is executed after redirection
            }
        }

        // If not logged in or form not submitted, show login form
        require_once __DIR__ . '/../views/Login/login.php';
    }




//    public function register()
//    {
//        $errorMessage = "";
//        if (isset($_POST["registerBtn"])) {
//            if (empty($_POST["username"])) {
//                $errorMessage = "Please fill out your first name";
//            }
//            else if (empty($_POST["email"])) {
//                $errorMessage = "Please fill out your email";
//            } else if (empty($_POST["password"])) {
//                $errorMessage = "Please fill out your password";
//            } else {
//                $this->createNewUser();
//            }
//        }
//        require __DIR__ . '/../views/Login/registeruser.php';
//    }

    public function createNewUser(): void
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

                $registrationSuccess = $this->userService->registered($newUser);

                if ($registrationSuccess) {
                    // Redirect to login page after successful registration
                    header("Location: /login/login");
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

        require __DIR__ . '/../views/Login/registeruser.php';
    }
}