<?php

namespace App\Controllers;

use App\model\history;
include '../config/constants.php';

class historyController
{

    private $historyService;

    public function __construct()
    {
        $this->historyService = new \App\Service\historyService();
    }

    public function index(): void
    {
        $sections = $this->historyService->getSectionsByPage(HISTORY_PAGE_ID);

        foreach ($sections as $key => $section) {
            if ($section['type'] === 'marketing') {
                $sections[$key]['carouselItems'] = $this->historyService->getCarouselItemsBySection($section['sectionId']);
            }
            $sections[$key]['images'] = $this->historyService->getImageBySection($section['sectionId']);
            $sections[$key]['paragraphs'] = $this->historyService->getParagraphsBySection($section['sectionId']);
            $sections[$key]['locations'] = $this->historyService->getLocationBySection($section['sectionId']);
            $sections[$key]['historyDetails'] = $this->historyService->getHistoryDetailsBySection($section['sectionId']);
        }

        $paragraphs= $this->historyService->getParagraphsBySection(21);
        $guides=$this->historyService->getGuideName();
        $guideNames = implode(", ", array_column($guides, 'guideName'));


        foreach ($paragraphs as $key => $paragraph) {

            $paragraphs[$key]['locations'] = $this->historyService->getLocationBySection($paragraph['paragraphId']);
        }
        require __DIR__ . '/../views/history/homepage.php';
    }

}