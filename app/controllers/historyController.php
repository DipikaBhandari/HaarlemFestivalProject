<?php

namespace App\Controllers;

use App\model\history;

class historyController
{

    private $historyService;

    public function __construct()
    {
        $this->historyService = new \App\Service\historyService();
    }

    public function index(): void
    {
        $sections = $this->historyService->getSectionsByPage(1);

        foreach ($sections as $key => $section) {
            if ($section['type'] === 'marketing') {
                $sections[$key]['carouselItems'] = $this->historyService->getCarouselItemsBySection($section['sectionId']);
            }
            $sections[$key]['images'] = $this->historyService->getImageBySection($section['sectionId']);
            $sections[$key]['paragraphs'] = $this->historyService->getParagraphsBySection($section['sectionId']);
            $sections[$key]['locations'] = $this->historyService->getLocationBySection($section['sectionId']);

        }

        $paragraphs= $this->historyService->getParagraphsBySection(21);

        foreach ($paragraphs as $key => $paragraph) {

            $paragraphs[$key]['locations'] = $this->historyService->getLocationBySection($paragraph['paragraphId']);
        }
//        if(isset($_GET['historyId'])) {
//            $historyId = $_GET['historyId'];
//            $paragraph = $this->historyService->getImageBySection($historyId);
//            echo json_encode($paragraph);
//            exit;
//        }
        require __DIR__ . '/../views/history/homepage.php';
    }
}