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
        if(isset($_GET['pageId'])) {
            $pageId = filter_var($_GET['pageId'], FILTER_SANITIZE_NUMBER_INT);
            $sections = $this->homeService->getSectionsByPage($pageId);

            foreach ($sections as $key => $section) {
                if ($section['type'] === 'crossnavigation') {
                    $sections[$key]['carouselItems'] = $this->homeService->getCarouselItemsBySection($section['sectionId']);
                }
                $sections[$key]['images'] = $this->homeService->getImageBySection($section['sectionId']);
                $sections[$key]['paragraphs'] = $this->homeService->getParagraphsBySection($section['sectionId']);
            }
        }

        require __DIR__ . '/../views/home/index.php';
    }
}