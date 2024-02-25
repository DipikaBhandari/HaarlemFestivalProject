<?php

namespace App\Controllers;

use App\service\restaurantService;

class restaurantController
{
    private $restaurantService;
    public function __construct()
    {
        $this->restaurantService = new restaurantService();
    }
    public function YummyHome(){
        $sections = $this->restaurantService->getSectionsByPage(3);

        //$headerSection = $this->restaurantService->getSectionByType('header', 2);
        //$introductionSection = $this->restaurantService->getSectionByType('introduction', 2);

        foreach ($sections as $key => $section) {
            $sections[$key]['images'] = $this->restaurantService->getImageBySection($section['sectionId']);
            $sections[$key]['paragraphs'] = $this->restaurantService->getParagraphsBySection($section['sectionId']);
            $sections[$key]['card'] = $this->restaurantService->getCardItemsBySection($section['sectionId']);
        }
        require __DIR__ .'/../views/yummy/YummyHome.php';
    }

}