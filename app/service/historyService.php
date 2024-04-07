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

    public function getHistoryDetailsForEditing($historyId){
        return $this->historyRepository->getHistoryDetail($historyId);
    }
    public function updateHistory($historyData)
    {
        // Validation and preparation of data for update
        // For example, ensure $historyData contains all necessary fields
        // and they are sanitized for security reasons

        // Convert the start and end time into the time format expected by the database, if necessary
        $timeString = $historyData['startTime'] . '-' . $historyData['endTime'];
        $languageIndicator = isset($historyData['languageIndicator']) ? $historyData['languageIndicator'] : '';

        // Prepare the data array for updating
        $dataToUpdate = [
            'historyId' => $historyData['historyId'], // Make sure this is included for identifying the record to update
            'date' => $historyData['date'],
            'time' => $timeString,
            'languageIndicator' =>  $languageIndicator,
            'guideId' => $historyData['guideId'],
            // Include any other fields that are part of the update
            'startTime' => $historyData['startTime'],
            'endTime' => $historyData['endTime']
        ];

        // Call the repository method to update the history
        // Assuming your historyRepository has a method named `updateHistory` for updating the data
        return $this->historyRepository->updateHistory($dataToUpdate);
    }
}