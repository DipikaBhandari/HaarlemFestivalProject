<?php

namespace App\Service;

use App\Repositories\pageManagementRepository;

class pageManagementService
{
    private $pageManagementRepository;
    public function __construct()
    {
        $this->pageManagementRepository = new \App\Repositories\pageManagementRepository();
    }

    public function getAllPages()
    {
       return $this->pageManagementRepository->getAllPages();
    }

    public function getSectionsByPage($pageId)
    {
        return $this->pageManagementRepository->getSectionsByPage($pageId);
    }

    public function getPageTitle( $pageId)
    {
        return $this->pageManagementRepository->getPageTitle($pageId);
    }

    public function getSectionContent($sectionId)
    {
        return $this->pageManagementRepository->getSectionContent($sectionId);
    }

    public function getParagraphsBySection($sectionId)
    {
        return $this->pageManagementRepository->getParagraphsBySection($sectionId);
    }

    public function updateParagraph($paragraph, $paragraphId)
    {
        $this->pageManagementRepository->updateParagraph($paragraph, $paragraphId);
    }

    public function addParagraph($paragraph, $sectionId)
    {
        $this->pageManagementRepository->addParagraph($paragraph, $sectionId);
    }

    public function deleteUnusedParagraphs($placeholders)
    {
        $this->pageManagementRepository->deleteUnusedParagraphs($placeholders);
    }

    public function updateSection($sectionId, $heading, $subTitle)
    {
        $this->pageManagementRepository->updateSection($sectionId, $heading, $subTitle);
    }

    public function updateImage($imageId,  $imagePath)
    {
        $this->pageManagementRepository->updateImage($imageId,  $imagePath);
    }

    public function addImage( $sectionId,  $imageName,  $imagePath)
    {
        $this->pageManagementRepository->addImage($sectionId, $imageName, $imagePath);
    }

    public function getImagesBySection($sectionId)
    {
        return $this->pageManagementRepository->getImagesBySection($sectionId);
    }
    public function getImageById($imageId)
    {
        return $this->pageManagementRepository->getImageById($imageId);
    }

    public function getSectionTypes()
    {
        return $this->pageManagementRepository->getSectionTypes();
    }

    public function addPage($pageTitle, $pageLink)
    {
        return $this->pageManagementRepository->addPage($pageTitle, $pageLink);
    }

    public function addSection($pageId, $sectionType, $heading, $subTitle)
    {
        return $this->pageManagementRepository->addSection($pageId, $sectionType, $heading, $subTitle);
    }

    public function deleteSection($sectionId)
    {
        return $this->pageManagementRepository->deleteSection($sectionId);
    }

    public function deletePage($pageId)
    {
        return $this->pageManagementRepository->deletePage($pageId);
    }

    public function getPageByLink($pageLink)
    {
        return $this->pageManagementRepository->getPageByLink($pageLink);
    }

    public function nav()
    {
        return $this->pageManagementRepository->nav();
    }
}