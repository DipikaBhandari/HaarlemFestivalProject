<?php

namespace App\Controllers;



use App\model\user;
use Exception;


require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../service/UserService.php';
class ManageHistoryController
{
    private $userService;
    private $userModel;
    private $historyService;


    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\user();
        $this->historyService= new \App\service\historyService();

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
        $historys = $this->historyService->getHistoryDetailsWithGuideNames();
        $guides = $this->historyService->fetchAllGuide();


        require __DIR__ . '/../views/manageHistory.php';
    }
    public function updateHistory(){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $languageIndicators = isset($data['languageIndicators']) ? $data['languageIndicators'] : '';

            $result = $this->historyService->updateHistory([
                'historyId' => $data['historyId'],
                'date' => $data['date'],
                'startTime' => $data['startTime'],
                'endTime' => $data['endTime'],
                'guideId' => $data['guideId'],
                'languageIndicators' => $languageIndicators,
            ]);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'History updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update history.']);
            }
        } else {
            // Handle invalid request method
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }
    public function addHistory() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        header('Content-Type: application/json');

        // Ensure the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect input data
            $date = $_POST['date'] ?? null;
            $startTime = $_POST['startTime'] ?? null;
            $endTime = $_POST['endTime'] ?? null;
            $guideId = $_POST['guideId'] ?? null;
            $languageIndicators = $_POST['languageIndicator'] ?? ''; // Expecting a comma-separated string

            // Basic validation (You should implement more robust validation/sanitization)
            if (!$date || !$startTime || !$endTime || !$guideId) {
                // Handle error; Required fields are missing
                echo "Error: All fields are required.";
                return;
            }

            // You might want to convert the $guideId to an integer and validate it further,
            // especially if your database expects an integer foreign key.
            $guideId = (int) $guideId;

            // Assuming your historyService has an addHistory method which takes an associative array of history data
            try {
                $result = $this->historyService->addHistory([
                    'date' => $date,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'guideId' => $guideId,
                    'languageIndicator' => $languageIndicators, // Directly pass the string
                ]);

                if ($result) {
                    // Success! Handle accordingly, maybe redirect or output success message
                    echo json_encode(['success' => true, 'message' => 'History added successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error adding history.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Error: Invalid request method.']);
        }
    }
    // ... [Previous Code]

    public function deleteHistory() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }
        header('Content-Type: application/json');
        // Ensure the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $historyId = $data['historyId'] ?? null;

            if (!$historyId) {
                echo json_encode(['success' => false, 'message' => 'History ID is required.']);
                return;
            }

            try {
                $result = $this->historyService->deleteHistory($historyId);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'History record deleted successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error deleting history record.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Error: Invalid request method.']);
        }
    }
    public function getHistoryDetails(){
        $historyId = $_GET['historyId'] ?? '';
        if(!$historyId){
            http_response_code(400);
            echo json_encode(['error' => 'history Id is required']);
            return;
        }
        try{
            $historyDetails= $this->historyService->getHistoryDetailsForEditing($historyId);
            if($historyDetails){
                echo json_encode($historyDetails);
                return;
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'History detail not found']);
            }
        }catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching history details: ' . $e->getMessage()]);
        }
    }
}

