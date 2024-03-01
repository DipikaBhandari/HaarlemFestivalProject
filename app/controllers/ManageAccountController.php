<?php
namespace App\Controllers;


use App\model\User;
use App\service\emailProfileChangeConfirmationService;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../service/UserService.php';

class ManageAccountController
{
    private $userService;
    private $userModel;
    private $emailProfileChange;


    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\User();
         $this->emailProfileChange = new emailProfileChangeConfirmationService();
    }

    public function showAccount() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        // Temporarily
        $_SESSION['email'] = 'adordawit4@gmail.com';
        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }

        // Fetch user data from the database using the UserService
        $user = $this->userService->getUserByEmail($_SESSION['email']);

        // Pass the user data to the view
        require __DIR__ . '/../views/manageAccount.php';
    }
    public function updateAccount()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['email'])) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'User not logged in']);
                exit;
            }
            $user = new User();

            $user->setEmail($_SESSION['email']);
            $user->setName(htmlspecialchars($_POST['name']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setAddress(htmlspecialchars($_POST['address']));
            $user->setPhoneNumber(htmlspecialchars($_POST['phoneNumber']));



            // Handle file upload
            $picture_path = $this->handleFileUpload();
            if ($picture_path !== null) {
                $user->setProfilePicture($picture_path);
            }
            //ob_start();
            $updateSuccess = $this->userService->updateUser($user);

            header('Content-Type: application/json');
            if ($updateSuccess) {

                $emailService = new emailProfileChangeConfirmationService();
                 ;
                if ($emailService->sendAccountUpdateEmail("adordawit4@gmail.com")){
                    echo json_encode(['success' => true, 'message' => 'Account updated successfully, confirmation email sent.']);
                } else {
                    echo json_encode(['success' => true, 'message' => 'Account updated successfully, but the confirmation email could not be sent.']);
               }
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'message' => 'Failed to update account']);
            }
        }
        else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
        exit;
    }
    private function handleFileUpload() {
        if (isset($_FILES['profilePictureInput']) && $_FILES['profilePictureInput']['error'] == UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../public/img/';
            $safeFilename = bin2hex(random_bytes(16)) . '.' . pathinfo($_FILES['profilePictureInput']['name'], PATHINFO_EXTENSION);
            $targetFile = $targetDir . $safeFilename;
            if (move_uploaded_file($_FILES['profilePictureInput']['tmp_name'], $targetFile)) {
                return '/img/' . $safeFilename;
            }
        }
        return null;
    }
    public function updatePassword() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'])) {
            if (!isset($_SESSION['email'])) {
                echo json_encode(['success' => false, 'message' => 'User not logged in']);
                exit;
            }
            $data = json_decode(file_get_contents('php://input'), true);
            $currentPassword = $data['currentPassword'] ?? '';
            $newPassword = $data['newPassword'] ?? '';

            if ($this->userService->verifyPassword($_SESSION['email'], $currentPassword)) {
                if ($this->userService->updateUserPassword($_SESSION['email'], $newPassword)) {
                    echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
            }
            exit;
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
    }
}
