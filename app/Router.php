<?php

namespace App;
class Router
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    public function route($uri)
    {
        if(!isset($_SESSION)){
            session_start();
        }
        $uri = $this->stripParameters($uri);
        $uriNoLeading = ltrim($uri, '/');
        $explodedUri = explode('/', $uriNoLeading);
        if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
            $explodedUri[0] = 'home';
        }
        $controllerName = "App\\Controllers\\" . $explodedUri[0] . "Controller";

        if ($explodedUri[0] === 'restaurant' && $explodedUri[1] === 'details' && isset($explodedUri[2])) {
            $restaurantId = $explodedUri[2];
            $controller = new Controllers\RestaurantController();
            $controller->details($restaurantId);
            return;
        }
        if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
            $explodedUri[1] = 'index';
        }
        $methodName = $explodedUri[1];

        // Controller/method matching the URL not found
        if (!class_exists($controllerName) || !method_exists($controllerName, $methodName)) {
            http_response_code(404);
            return;
        }

        // Check authorization
        if (!$this->isAuthorized($controllerName, $methodName)) {
            require __DIR__ . '/views/noAuthorization.php';
            exit;
        }

        if ($explodedUri[0] === 'restaurant' && $explodedUri[1] === 'details' && isset($explodedUri[2])) {
            $restaurantId = $explodedUri[2];
            $controller = new Controllers\RestaurantController();
            $controller->details($restaurantId);
            return;
        }
        try {
            $controllerObj = new $controllerName();
            $controllerObj->$methodName();
        } catch (\App\Error $e) {
            // For some reason the class/method doesn't work
            http_response_code(500);
        }
    }

    // Check if the user is authorized to access the controller/method
    private function isAuthorized($controller, $method)
    {
        // Check if the user is logged in
        $loggedIn = $this->userIsLoggedIn();

        // Check if the user is an admin
        $isAdmin = $this->userIsAdmin();

        // Check if the user is an employee
        $isEmployee = $this->userIsEmployee();


        // Check authorization based on controller/method
        switch ($controller) {
            case 'App\Controllers\pageManagementController':
                if ($method === 'showPage' || $method === 'nav') {
                    //everyone can see these pages
                    return true;
                }
                // Only admin can access rest of PageManagementController
                return $loggedIn && $isAdmin;
            case 'App\Controllers\ManageAccountController':
                // Only logged-in users can access ManageAccountController
                return $loggedIn;
            case 'App\Controllers\orderController':
                // Allow access to certain methods based on user role
                if ($method === 'scanTicket' || $method === 'verifyTicket') {
                    // Only logged-in employees can access scanTicket and verifyTicket
                    return $loggedIn && $isEmployee;
                }
                // Allow access to other methods for logged-in users
                return $loggedIn;
            default:
                // Allow access to other controllers/methods for all users
                return true;
        }
    }

    private function userIsLoggedIn()
    {
        return isset($_SESSION['username']);
    }

    private function userIsEmployee()
    {
        return isset($_SESSION["role"]) && $_SESSION["role"] === "Employee";
    }

    private function userIsAdmin()
    {
        return isset($_SESSION["role"]) && $_SESSION["role"] === "Administrator";
    }

}