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

    public function getSectionContent(){
        if(isset($_GET['sectionId'])) {
            $sectionId = $_GET['sectionId'];
            $sectionContent = $this->pageManagementService->getSectionContent($sectionId);
            echo json_encode($sectionContent);
        }
        else{
            echo json_encode(['error' => 'Section ID is not provided']);
        }
    }

    public function saveNewContent(){
        if (isset($_POST['sectionId']) && isset($_POST['content'])){
            $sectionId = $_POST['sectionId'];
            $content = $_POST['content'];

            $heading = '';
            $subTitle='';
            preg_match_all('/<h(\d)>(.*?)<\/h\1>/', $content, $matches, PREG_SET_ORDER);
            if (isset($matches[0])) {
                $heading = $matches[0][0]; // First match is considered as heading
                if (isset($matches[1])) {
                    $subTitle = $matches[1][0]; // Second match (if exists) is considered as subtitle
                }
            }
            $this->pageManagementService->updateSection($sectionId, $heading, $subTitle);

            //split content into paragraphs
            $paragraphs = explode('<p>', $content);
            var_dump($paragraphs);
            array_shift($paragraphs);
            $existingParagraphs = $this->pageManagementService->getParagraphsBySection($sectionId);

            foreach($paragraphs as $key => $paragraph){
                if(!empty($existingParagraphs)) {
                    $paragraphId = array_shift($existingParagraphs);
                    $this->pageManagementService->updateParagraph($paragraph, $paragraphId);
                } else{
                    $this->pageManagementService->addParagraph($paragraph, $sectionId);
                }
            }
            if (!empty($existingParagraphs)) {
                $placeholders = rtrim(str_repeat('?,', count($existingParagraphs)), ',');
                $this->pageManagementService->deleteUnusedParagraphs($placeholders);
            }
        }
        if(isset($_FILES['images'])) {
            $uploadedImages = $_FILES['images'];
            foreach ($uploadedImages['tmp_name'] as $key => $tmp_name) {
                $imageTmpName = $tmp_name;
                $imageName = $uploadedImages['name'][$key];
                $imageId = $key;

                // Check if there are existing images associated with the section
                $existingImages = $this->pageManagementService->getImageById($imageId);

                if ($existingImages) {
                    // If existing images are found, update their paths
                    foreach ($existingImages as $existingImage) {
                        $imageId = $existingImage['imageId'];
                        $imagePath = "/img/" . $imageName; // Assuming the path remains the same
                        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                    move_uploaded_file($imageTmpName, $uploadPath);
                        $this->pageManagementService->updateImage($imageId, $imagePath);
                    }
                } else {
                    // If no existing images are found, upload the new image
                    $imagePath = "/img/" . $imageName;
                    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                    move_uploaded_file($imageTmpName, $uploadPath);
                    $this->pageManagementService->addImage($sectionId, $imageName, $imagePath);
                }
            }
        }
    }
}