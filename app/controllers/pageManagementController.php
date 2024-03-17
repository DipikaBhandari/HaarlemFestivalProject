<?php

namespace App\Controllers;
use DOMDocument;

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
        $pageId = filter_var($_GET['pageId'],FILTER_SANITIZE_NUMBER_INT);
        $pageTitle = $this->pageManagementService->getPageTitle($pageId);
        $sections = $this->pageManagementService->getSectionsByPage($pageId);
        require __DIR__ . '/../views/sectionEditor.php';
    }

    public function getSectionContent(){
        if(isset($_GET['sectionId'])) {
            $sectionId = filter_var($_GET['sectionId'],FILTER_SANITIZE_NUMBER_INT);
            $sectionContent = $this->pageManagementService->getSectionContent($sectionId);
            echo json_encode($sectionContent);
        }
        else{
            echo json_encode(['error' => 'Section ID is not provided']);
        }
    }

    public function saveNewContent(){
        if (isset($_POST['sectionId']) && isset($_POST['content'])){
            $sectionId = filter_var($_POST['sectionId'],FILTER_SANITIZE_NUMBER_INT);
            $content = $_POST['content'];

            list($heading, $subTitle) = $this->extractHeadingAndSubTitle($content);
            $this->pageManagementService->updateSection($sectionId, $heading, $subTitle);

            $paragraphs = $this->extractParagraphs($content);
            $this->updateParagraphs($paragraphs, $sectionId);
        }

        $this->uploadImages($_FILES['images'] ?? [], $sectionId);
    }

    private function extractHeadingAndSubTitle($content) {
        $dom = new DOMDocument();
        @$dom->loadHTML($content);
        $heading="";
        $subTitle = "";

        for ($i = 1; $i <= 6; $i++) {
            // Get all elements of current header tag
            $currentHeadings = $dom->getElementsByTagName("h$i");

            // Iterate over each header tag element and append it to $headings
            foreach ($currentHeadings as $currentHeading) {
                $headings[] = $currentHeading;
            }
        }

        if (!empty($headings)) {
            // Get the first element as heading
            $heading = $dom->saveHTML($headings[0]);

            // If more than one element found, get the second element as subtitle
            if (count($headings) > 1) {
                $subTitle = $dom->saveHTML($headings[1]);
            }
        }
        return [$heading, $subTitle];
    }

    private function extractParagraphs($content) {
        $dom = new DOMDocument();
        @$dom->loadHTML($content);
        $paragraphs = $dom->getElementsByTagName('p');

        $filteredParagraphs = [];

        foreach ($paragraphs as $paragraph) {
            $paragraphContent = $dom->saveHTML($paragraph);
            if(trim(strip_tags($paragraphContent)) !== ''){
                $filteredParagraphs[] = $paragraphContent;
            }
        }
        return $filteredParagraphs;
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
            $pageTitle = filter_var($_POST['pageTitle'],FILTER_SANITIZE_STRING);
            $pageLink = '/pageManagement/' . 'showPage';
            $pageId = $this->pageManagementService->addPage($pageTitle, $pageLink);

            if (isset($_POST['sections']) && is_array($_POST['sections'])) {
                foreach ($_POST['sections'] as $index => $section) {
                    $sectionType = filter_var($section['sectionType'], FILTER_SANITIZE_STRING);
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
            $sectionId = filter_var($_GET['sectionId'], FILTER_SANITIZE_NUMBER_INT);
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
            $pageId = filter_var($_GET['pageId'], FILTER_SANITIZE_NUMBER_INT);
            $sections = $this->pageManagementService->getSectionsByPage($pageId);
            foreach ($sections as $section) {
                $this->pageManagementService->deleteSection(filter_var($section['sectionId'], FILTER_SANITIZE_NUMBER_INT));
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
            $pageId = filter_var($_GET['pageId'], FILTER_SANITIZE_NUMBER_INT);
            $sections = $this->pageManagementService->getSectionsByPage($pageId);
            foreach ($sections as $key => $section) {
                $sections[$key]['images'] = $this->pageManagementService->getImagesBySection(filter_var($section['sectionId'], FILTER_SANITIZE_NUMBER_INT));
                $sections[$key]['paragraphs'] = $this->pageManagementService->getParagraphsBySection(filter_var($section['sectionId'], FILTER_SANITIZE_NUMBER_INT));
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
            $pageId = filter_var($section['pageId'], FILTER_SANITIZE_NUMBER_INT);
            $sectionType = filter_var($section['sectionType'], FILTER_SANITIZE_STRING);

            if (isset($section['content']) && !empty($section['content'])){
                $content = $section['content'];

                list($heading, $subTitle) = $this->extractHeadingAndSubTitle($content);
                $sectionId = $this->pageManagementService->addSection($pageId, $sectionType, $heading, $subTitle);

                $paragraphs = $this->extractParagraphs($content);
                foreach ($paragraphs as $paragraph){
                    $this->pageManagementService->addParagraph($paragraph, $sectionId);
                }
            }

            if (isset($_FILES['section']['tmp_name']['images']) && is_array($_FILES['section']['tmp_name']['images'])) {
                $sectionId = $this->pageManagementService->addSection($pageId, $sectionType, "", "");
                $tmpName = $_FILES['section']['tmp_name']['images'];
                $imageName = $_FILES['section']['name']['images'];
                $this->uploadImagesForSection($imageName, $tmpName, $sectionId);
            } else {
                echo json_encode('No image uploaded.');
            }
        }
    }
}