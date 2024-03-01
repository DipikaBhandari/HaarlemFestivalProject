<?php

namespace App\model;

class image
{
    private int $imageId;
    private int $sectionId;
    private string $imageName;
    private string $imagePath;

    public function getImageId(): int
    {
        return $this->imageId;
    }

    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    public function setSectionId(int $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    public function getImageName(): string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }
}