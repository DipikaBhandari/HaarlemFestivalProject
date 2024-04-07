<?php

namespace App\Controllers;

namespace App\Controllers;
use App\service\orderService;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ManageOrderController
{
    private $userService;
    private $userModel;
    private $orderService;


    public function __construct()
    {
        $this->userService = new \App\Service\userService();
        $this->userModel = new \App\model\user();
        $this->orderService= new \App\service\orderService();
    }

    public function manageOrder()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit;
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['export_csv'])) {
                $this->exportToCSV($_POST['columns']);
            }
            // Check if the export to Excel button was clicked
            if (isset($_POST['export_excel'])) {
                $this->exportToExcel($_POST['columns']);
            }
        }

        $user = $this->userService->getUserByEmail($_SESSION['email']);
        $orderDetails = $this->orderService->getOrderDetails();
        require __DIR__ . '/../views/manageOrder.php';
    }
    function exportToExcel($selectedColumns) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Column headers
        $columnIndex = 'A';
        foreach ($selectedColumns as $column) {
            $sheet->setCellValue($columnIndex . '1', $column);
            $columnIndex++;
        }

        // Fetch data and add to spreadsheet
        $orders = $this->orderService->getOrderDetails();
        $rowNumber = 2;
        foreach ($orders as $row) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $column) {
                $sheet->setCellValue($columnIndex . $rowNumber, $row[$column] ?? 'N/A');
                $columnIndex++;
            }
            $rowNumber++;
        }

        // Headers for browser download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="orders.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    function exportToCSV($selectedColumns) {
        // Define the filename with a dynamic date
        $filename = "orders_" . date('Ymd') . ".csv";

        // Set headers to prompt for download rather than displaying the content
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        // Prevent caching
        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
        header('Pragma: no-cache'); // HTTP 1.0
        header('Expires: 0'); // Proxies

        // Open the output stream
        $output = fopen('php://output', 'w');

        // Output the column headings
        fputcsv($output, $selectedColumns);

        // Fetch the data from the order service
        $orders = $this->orderService->getOrderDetails();

        // Loop over each order and extract the data for selected columns
        foreach ($orders as $row) {
            $data = [];
            foreach ($selectedColumns as $column) {

                $data[] = $row[$column] ?? 'N/A'; // Use 'N/A' for missing data
            }
            // Write the row to the CSV file
            fputcsv($output, $data);
        }


        fclose($output);
        exit();
    }

}