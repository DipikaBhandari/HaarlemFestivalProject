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
}