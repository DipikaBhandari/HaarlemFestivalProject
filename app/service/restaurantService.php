<?php

namespace App\service;
use App\Repositories\restaurantRepository;
class restaurantService
{
    private $restaurantRepository;

    public function __construct(){
        $this->restaurantRepository = new restaurantRepository();
    }
    public function getSectionsByPage($pageId){
        return $this->restaurantRepository->getSectionsByPage($pageId);
    }
    public function getImageBySection($sectionId){
        return $this->restaurantRepository->getImagesBySection($sectionId);
    }
    public function getParagraphsBySection($sectionId){
        return $this->restaurantRepository->getParagraphsBySection($sectionId);
    }
    public function getCarouselItemsBySection($sectionId)
    {
        return $this->restaurantRepository->getCarouselItemsBySection($sectionId);
    }
    public function getCardItemsBySection($sectionId)
    {
        return $this->restaurantRepository->getCardItemsBySection($sectionId);
    }

}