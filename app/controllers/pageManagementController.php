<?php

namespace App\Controllers;

class pageManagementController
{
    private $pageManagementService;

    public function __construct()
    {
        $this->pageManagementService = new \App\Service\pageManagementService();
    }
    public function index() {
        $pages = $this->pageManagementService->getAllPages();
        require __DIR__ . '/../views/pageEditor.php';
    }

    public function sections(){
        $pageId = $_GET['pageId'];
        $pageTitle = $this->pageManagementService->getPageTitle($pageId);
        $sections = $this->pageManagementService->getSectionsByPage($pageId);
        require __DIR__ . '/../views/sectionEditor.php';
    }

    public function getSectionContent (){
        if(isset($_GET['sectionId'])) {
            $sectionId = $_GET['sectionId'];
            $sectionContent = $this->pageManagementService->getSectionContent($sectionId);
            echo json_encode($sectionContent);
        }
        else{
            echo json_encode(['error' => 'Section ID is not provided']);
        }
    }
}