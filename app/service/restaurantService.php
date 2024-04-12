<?php

namespace App\service;
use App\Repositories\restaurantRepository;
use Exception;

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

    public function getYummyImageBySection($restaurantSectionId){
        return $this->restaurantRepository->getYummyImageBySection($restaurantSectionId);
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

//    public function updateRestaurantDetails($restaurantDetails)
//    {
//        return $this->restaurantRepository->updateRestaurantDetails($restaurantDetails);
//    }
    /**
     * @throws Exception
     */
    public function updateRestaurantDetails($restaurantId, $data)
    {
        if (empty($restaurantId) || !isset($data['restaurantName'])) {
            throw new Exception('Required restaurant details are missing.');
        }

        // Assuming data is already sanitized and validated
        $result = $this->restaurantRepository->updateRestaurantDetails($restaurantId, $data);

        if (!$result) {
            throw new Exception('Failed to update restaurant details.');
        }

        return $result;
    }
    public function createNewRestaurant($restaurantData)
    {
        return $this->restaurantRepository->create($restaurantData);
    }
    Public function getSessionById($sessionId) {
        return $this->restaurantRepository->getSessionById($sessionId);
    }

    public function updateSessionSeats($sessionId, $newCapacity) {
        return $this->restaurantRepository->updateSessionSeats($sessionId, $newCapacity);
    }

    public function createReservation($reservationData) {
        return $this->restaurantRepository->createReservation($reservationData);
    }
    public function getSessionsForRestaurantId($restaurantId) {
        return $this->restaurantRepository->getSessionsForRestaurantId($restaurantId);
    }

    public function deleteRestaurant($restaurantId)
    {
        return $this->restaurantRepository->deleteRestaurant($restaurantId);
    }
}
