<?php

namespace App\Controllers;
include '../config/constants.php';
class HomeController
{
    private $homeService;

    public function __construct()
    {
        $this->homeService = new \App\Service\homeService();
    }

    public function index()
    {
        $pageId = HOME_PAGE_ID;
        $sections = $this->homeService->getSectionsByPage($pageId);

        foreach ($sections as $key => $section) {
            if ($section['type'] === 'crossnavigation') {
                $sections[$key]['carouselItems'] = $this->homeService->getCarouselItemsBySection($section['sectionId']);
            }
            $sections[$key]['images'] = $this->homeService->getImageBySection($section['sectionId']);
            $sections[$key]['paragraphs'] = $this->homeService->getParagraphsBySection($section['sectionId']);
        }
        require __DIR__ . '/../views/home/index.php';
    }
}