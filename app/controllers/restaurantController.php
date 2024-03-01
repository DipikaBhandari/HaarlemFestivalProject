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
        $locations = $this->restaurantService->getAllYummyLocations();
        require __DIR__ .'/../views/yummy/YummyHome.php';
    }
    public function details($restaurantId)
    {
        // Fetch details for the specific restaurant
        $restaurantDetails = $this->restaurantService->getRestaurantDetails($restaurantId);
        if ($restaurantDetails) {

            $sections = $this->restaurantService->getSectionsForRestaurant($restaurantId);
            foreach ($sections as $key => $section) {

                //$sections[$key]['Yummy'] = $this->restaurantService->getRestaurantDetails($section['restaurantSectionId']);
                $sections[$key]['paragraphs'] = $this->restaurantService->getYummyParagraphsBySection($section['restaurantSectionId']);
                $sections[$key]['OpeningTime'] = $this->restaurantService->getYummyOpeningBySection($section['restaurantSectionId']);


                //$sections[$key]['card'] = $this->restaurantService->getCardItemsBySection($section['restaurantSectionId']);
            }
            // Pass the restaurant details and sections to the view
            require __DIR__ . '/../views/yummy/details.php';
        }
        else{
            // Handle not found
            http_response_code(404);
            echo "Restaurant not found";
            return;
        }
    }
}