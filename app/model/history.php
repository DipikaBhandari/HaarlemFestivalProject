<?php

namespace App\model;

class history
{
    private string $locationPicture;

    private string $location;

    private string $description;

    private int $historyId;

    private int $paragraphId;


    public function getHistoryId(): int
    {
        return $this->historyId;
    }

    public function setHistoryId(int $historyId): void
    {
        $this->historyId = $historyId;
    }

    public function getParagraphId(): int
    {
        return $this->paragraphId;
    }

    public function setParagraphId(int $paragraphId): void
    {
        $this->paragraphId = $paragraphId;
    }

    public function getLocationPicture(): string
    {
        return $this->locationPicture;
    }

    public function setLocationPicture(string $locationPicture): void
    {
        $this->locationPicture = $locationPicture;
    }

    public function setDescription(): string
    {
        return $this->description;
    }

    public function getDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setLocation(): string
    {
        return $this->location;
    }

    public function getLocation(string $location): void
    {
        $this->location = $location;
    }



}