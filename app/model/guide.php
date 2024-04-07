<?php

namespace App\model;

class guide
{
    private int $guideId;
    private string $guideName;
    private int $historyId;

    public function getHistoryId(): int
    {
        return $this->historyId;
    }

    public function setHistoryId(int $historyId): void
    {
        $this->historyId = $historyId;
    }
    public function getGuideId(): int
    {
        return $this->guideId;
    }

    public function setGuideId(int $guideId): void
    {
        $this->guideId = $guideId;
    }

    public function getGuideName(): string
    {
        return $this->guideName;
    }

    public function setGuideName(string $guideName): void
    {
        $this->guideName = $guideName;
    }
}