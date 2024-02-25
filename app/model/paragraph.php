<?php

namespace App\model;

class paragraph
{
    private int $paragraphId;
    private int $sectionId;
    private string $text;

    public function getParagraphId(): int
    {
        return $this->paragraphId;
    }

    public function setParagraphId(int $paragraphId): void
    {
        $this->paragraphId = $paragraphId;
    }

    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    public function setSectionId(int $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}