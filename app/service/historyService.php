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
    public function getCarouselItemsBySection($sectionId)
    {
        return $this->historyRepository->getCarouselItemsBySection($sectionId);
    }

    public function getHistoryDetailsWithGuideNames()
    {
        return $this->historyRepository->getHistoryDetailsWithGuideNames();
    }

    public function fetchAllGuide()
    {
        return $this->historyRepository->fetchAllGuide();
    }
    public function addHistory($historyData)
    {
        // Convert the start and end time into the time format expected by the database
        $timeString = $historyData['startTime'] . '-' . $historyData['endTime'];

        // Prepare the data array to be inserted
        $dataToInsert = [
            'date' => $historyData['date'],
            'time' => $timeString,
            'languageIndicator' => $historyData['languageIndicator'],
            'guideId' => $historyData['guideId'],
            'sectionId' => 22,
            'startTime' => $historyData['startTime'],
            'endTime' => $historyData['endTime']
        ];

        return $this->historyRepository->insertHistory($dataToInsert);
    }
    public function deleteHistory($historyId)
    {
        return $this->historyRepository->deleteHistory($historyId);
    }


}