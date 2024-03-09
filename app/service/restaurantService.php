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
    public function getRestaurantDetails($restaurantId)
    {
        return $this->restaurantRepository->find($restaurantId);
    }
    public function getSectionsForRestaurant($restaurantId)
    {
        return $this->restaurantRepository->getSectionsForRestaurant($restaurantId);
    }
    public function getYummyParagraphsBySection($restaurantSectionId){
        return $this->restaurantRepository->getYummyParagraphsBySection($restaurantSectionId);
    }
    public function getYummyOpeningBySection($restaurantSectionId){
        return $this->restaurantRepository->getYummyOpeningBySection($restaurantSectionId);
    }
    public function getAllYummyLocations() {
        return $this->restaurantRepository->getAllYummyLocations();
    }

    public function getAllYummyInfo() {
        return $this->restaurantRepository->getAllYummyInfo();
    }
    public function findDetail(int $restaurantId)
    {
        return $this->restaurantRepository->findDetail($restaurantId);
    }
}
