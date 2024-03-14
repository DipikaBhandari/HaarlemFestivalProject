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

            list($heading, $subTitle) = $this->extractHeadingAndSubTitle($content);
            $this->pageManagementService->updateSection($sectionId, $heading, $subTitle);

            $paragraphs = $this->extractParagraphs($content);
            $this->updateParagraphs($paragraphs, $sectionId);
        }

        $this->uploadImages($_FILES['images'] ?? [], $sectionId);
    }

    private function extractHeadingAndSubTitle($content) {
        $heading = '';
        $subTitle = '';
        preg_match_all('/<h(\d)>(.*?)<\/h\1>/', $content, $matches, PREG_SET_ORDER);
        if (isset($matches[0])) {
            $heading = $matches[0][0]; // First match is considered as heading
            if (isset($matches[1])) {
                $subTitle = $matches[1][0]; // Second match (if exists) is considered as subtitle
            }
        }
        return [$heading, $subTitle];
    }

    private function extractParagraphs($content) {
        // Extract paragraphs using a regular expression
        preg_match_all('/<p>(.*?)<\/p>/', $content, $matches);

        // Filter out paragraphs containing only whitespace characters
        $filteredParagraphs = array_filter($matches[1], function($paragraph) {
            // Trim the paragraph and check if it's empty after trimming
            return trim($paragraph) !== '';
        });

        // Wrap the filtered paragraphs with <p> tags
        $paragraphs = array_map(function($paragraph) {
            return "<p>$paragraph</p>";
        }, $filteredParagraphs);

        return $paragraphs;
    }

    private function updateParagraphs($paragraphs, $sectionId) {
        $existingParagraphs = $this->pageManagementService->getParagraphsBySection($sectionId);
        if (!empty($existingParagraphs)){
            $this->pageManagementService->deleteParagraphsBySection($sectionId);
        }
        foreach ($paragraphs as $key => $paragraph) {
            $this->pageManagementService->addParagraph($paragraph, $sectionId);
        }
    }

    private function deleteUnusedParagraphs($paragraphs, $sectionId) {
        $existingParagraphs = $this->pageManagementService->getParagraphsBySection($sectionId);
        if (count($existingParagraphs) > count($paragraphs)) {
            $placeholders = rtrim(str_repeat('?,', count($existingParagraphs)), ',');
            $this->pageManagementService->deleteUnusedParagraphs($placeholders);
        }
    }

    private function uploadImages($uploadedImages, $sectionId) {
        var_dump($uploadedImages);
        foreach ($uploadedImages['tmp_name'] as $key => $tmp_name) {
            $imageTmpName = $tmp_name;
            $imageName = $uploadedImages['name'][$key];
            $imageId = $key;

            $this->processImage($imageTmpName, $imageName, $imageId, $sectionId);
        }
    }

    private function processImage($imageTmpName, $imageName, $imageId, $sectionId) {
        $existingImages = $this->pageManagementService->getImageById($imageId);
        if ($existingImages) {
            foreach ($existingImages as $existingImage) {
                $imageId = $existingImage['imageId'];
                $imagePath = "/img/" . $imageName; // Assuming the path remains the same
                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                move_uploaded_file($imageTmpName, $uploadPath);
                $this->pageManagementService->updateImage($imageId, $imagePath);
            }
        } else {
            $imagePath = "/img/" . $imageName;
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
            move_uploaded_file($imageTmpName, $uploadPath);
            $this->pageManagementService->addImage($sectionId, $imageName, $imagePath);
        }
    }

    public function addPage(){
        require __DIR__ . '/../views/addPage.php';
    }

    public function getSectionTypes(){
        $sectionTypes = $this->pageManagementService->getSectionTypes();
        echo json_encode($sectionTypes);
    }

    public function savePage(){
        if (isset($_POST['pageTitle'])){
            $pageTitle = $_POST['pageTitle'];
            $pageLink = '/pageManagement/' . 'showPage';
            $pageId = $this->pageManagementService->addPage($pageTitle, $pageLink);

            if (isset($_POST['sections']) && is_array($_POST['sections'])) {
                foreach ($_POST['sections'] as $index => $section) {
                    $sectionType = $section['sectionType'];
                    $content = $section['content'];

                    list($heading, $subTitle) = $this->extractHeadingAndSubTitle($content);
                    $sectionId = $this->pageManagementService->addSection($pageId, $sectionType, $heading, $subTitle);

                    $paragraphs = $this->extractParagraphs($content);
                    foreach ($paragraphs as $paragraph){
                        $this->pageManagementService->addParagraph($paragraph, $sectionId);
                    }
                    if (isset($_FILES['sections']['tmp_name'][$index]['images'])) {
                        $tmpName = $_FILES['sections']['tmp_name'][$index]['images'];
                        $imageName = $_FILES['sections']['name'][$index]['images'];
                        $this->uploadImagesForSection($imageName, $tmpName, $sectionId);
                    } else {
                        echo json_encode('No image uploaded for section ' . ($index + 1));
                    }
                }
            }
        } else{
            echo json_encode('An error occurred while saving the page. Please try again.');
        }
    }

    private function uploadImagesForSection($imageNames, $imageTmpNames, $sectionId)
    {
        foreach ($imageNames as $key => $imageName) {
            $imageTmpName = $imageTmpNames[$key];
            $imagePath = "/img/" . $imageName;
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
            move_uploaded_file($imageTmpName, $uploadPath);

            $this->pageManagementService->addImage($sectionId, $imageName, $imagePath);
        }
    }

    public function deleteSection(){
        if (isset($_GET['sectionId'])) {
            $sectionId = $_GET['sectionId'];
            $success = $this->pageManagementService->deleteSection($sectionId);
            if($success) {
                // Redirect to the page where the section was deleted from
                header("Location: /pageManagement/sections?pageId=" . $_GET['pageId']);
                exit();
            } else {
                // Handle failure to delete the section
                echo "Failed to delete section.";
            }
        } else {
            echo "Section ID is not provided";
        }
    }

    public function deletePage(){
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
            $sections = $this->pageManagementService->getSectionsByPage($pageId);
            foreach ($sections as $section) {
                $this->pageManagementService->deleteSection($section['sectionId']);
            }
            $success = $this->pageManagementService->deletePage($pageId);
            if($success) {
                // Redirect to the page where the section was deleted from
                header("Location: /pageManagement");
                exit();
            } else {
                // Handle failure to delete the section
                echo "Failed to delete page.";
            }
        } else {
            echo "Page ID is not provided";
        }
    }

    public function showPage(){
        session_start();
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
            $sections = $this->pageManagementService->getSectionsByPage($pageId);
            foreach ($sections as $key => $section) {
                $sections[$key]['images'] = $this->pageManagementService->getImagesBySection($section['sectionId']);
                $sections[$key]['paragraphs'] = $this->pageManagementService->getParagraphsBySection($section['sectionId']);
            }
            require __DIR__ . '/../views/pageTemplate.php';
        }
    }
    public function nav(){
        try {
            $pages = $this->pageManagementService->nav();
            echo json_encode($pages);
        } catch (\Exception $e){
            echo json_encode($e->getMessage());
        }
    }

    public function saveSection(){

        if (isset($_POST['section']) && isset($_POST['section']['pageId'])) {
            $section = $_POST['section'];
            $pageId = $section['pageId'];
            $sectionType = $section['sectionType'];
            $content = $section['content'];

            list($heading, $subTitle) = $this->extractHeadingAndSubTitle($content);
            $sectionId = $this->pageManagementService->addSection($pageId, $sectionType, $heading, $subTitle);

            $paragraphs = $this->extractParagraphs($content);
            foreach ($paragraphs as $paragraph){
                $this->pageManagementService->addParagraph($paragraph, $sectionId);
            }
            if (isset($_FILES['section']['tmp_name']['images']) && is_array($_FILES['section']['tmp_name']['images'])) {
                $tmpName = $_FILES['section']['tmp_name']['images'];
                $imageName = $_FILES['section']['name']['images'];
                $this->uploadImagesForSection($imageName, $tmpName, $sectionId);
            } else {
                echo json_encode('No image uploaded.');
            }
        }
    }
}