<?php

namespace App\Controllers;

class HomeController
{
    private $homeService;

    public function __construct()
    {
        $this->homeService = new \App\Service\homeService();
    }

    public function index()
    {
        $sections = $this->homeService->getSectionsByPage(1);

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