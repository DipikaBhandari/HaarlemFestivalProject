<?php
namespace App\Controllers;


use App\model\user;
use Exception;


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../service/UserService.php';

class ManageUsersController
{
    private $userService;
    private $userModel;


    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\user();

    }

    public function manageuser()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }

        // Fetch user data from the database using the UserService
        $user = $this->userService->getUserByEmail($_SESSION['email']);
        $users = $this->userService->fetchAllUsers();
        // Pass the user data to the view
        require __DIR__ . '/../views/manageUsers.php';
    }

    public function updateUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            // Validate data or ensure it's sanitized
            $userId = $data['id'] ?? null;
            $username = $data['username'] ?? '';
            $email = $data['email'] ?? '';
            $address = $data['address'] ?? '';
            $phoneNumber = $data['phonenumber'] ?? '';
            $role = $data['role'] ?? '';

            // Create a new User object and set its properties
            $user = new \App\model\user();
            $user->setUserId($userId);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setAddress($address);
            $user->setPhoneNumber($phoneNumber);
            $user->setRole($role);

            // Call the service method to update the user
            $result = $this->userService->updateUser($user);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'User updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }


    public function addUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Decode JSON payload from request body
            $data = json_decode(file_get_contents('php://input'), true);

            // Extract user input from decoded JSON, with fallbacks for missing values
            $username = !empty($data["username"]) ? htmlspecialchars($data["username"]) : '';
            $password = !empty($data["password"]) ? htmlspecialchars($data["password"]) : '';
            $email = !empty($data['email']) ? htmlspecialchars($data['email']) : '';
            $address = !empty($data['address']) ? htmlspecialchars($data['address']) : '';
            $phoneNumber = !empty($data['phoneNumber']) ? htmlspecialchars($data['phoneNumber']) : '';
            $role = !empty($data["role"]) ? $data["role"] : 'Customer';
            try {
                $user = new user();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setAddress($address);
                $user->setPhoneNumber($phoneNumber);
                $user->setRole($role);
                try {
                    if ($this->userService->createUser($user)) {
                        echo json_encode(['success' => true, 'message' => 'User added successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to add user']);
                    }
                } catch (Exception $e) {
                    error_log("Error during registration: " . $e->getMessage());
                    echo json_encode(['success' => false, 'message' => 'Exception occurred']);
                }
                exit;
            } catch (Exception $e) {
                error_log("Error during registration: " . $e->getMessage());
                return false;
            }
        }
    }

    public function deleteUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = $data['username'] ?? null;

            if ($this->userService->deleteUser($username)) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
            }
        } else {
            // Handle incorrect request method
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }

    public function getUserDetails()
    {
        $username = $_GET['username'] ?? '';
        if (!$username) {
            http_response_code(400);
            echo json_encode(['error' => 'Username is required']);
            return;
        }
        try {
            $userDetails = $this->userService->getUserDetailsForEditing($username);

            if ($userDetails) {
                echo json_encode($userDetails);
                return;
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching user details: ' . $e->getMessage()]);
        }
    }
}
