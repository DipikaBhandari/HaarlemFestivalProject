<?php

namespace App\service;

use App\Repositories\homepageRepository;

class homeService
{
    private $homepageRepository;

    public function __construct()
    {
        $this->homepageRepository = new homepageRepository();
    }
    public function getSectionsByPage($pageId){
        return $this->homepageRepository->getSectionsByPage($pageId);
    }
    public function getImageBySection($sectionId){
        return $this->homepageRepository->getImagesBySection($sectionId);
    }
    public function getParagraphsBySection($sectionId){
        return $this->homepageRepository->getParagraphsBySection($sectionId);
    }
    public function getCarouselItemsBySection($sectionId)
    {
        return $this->homepageRepository->getCarouselItemsBySection($sectionId);
    }
}