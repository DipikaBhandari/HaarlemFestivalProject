<?php

namespace App\service;

use App\Repositories\historyRepository;

class historyService
{
    private $historyRepository;

    public function __construct()
    {
        $this->historyRepository = new historyRepository();
    }
    public function getSectionsByPage($pageId){
        return $this->historyRepository->getSectionsByPage($pageId);
    }
    public function getImageBySection($sectionId){
        return $this->historyRepository->getImagesBySection($sectionId);
    }
    public function getParagraphsBySection($sectionId){
        return $this->historyRepository->getParagraphsBySection($sectionId);
    }

    public function getLocationBySection($sectionId){
        return $this->historyRepository->getLocationBySection($sectionId);
    }
    public function getHistoryDetailsBySection($sectionId){
        return $this->historyRepository->getHistoryDetailsBySection($sectionId);
    }
    public function getCarouselItemsBySection($sectionId)
    {
        return $this->historyRepository->getCarouselItemsBySection($sectionId);
    }

    public function getGuideName()
    {
        return $this->historyRepository->getGuideName();
    }
}