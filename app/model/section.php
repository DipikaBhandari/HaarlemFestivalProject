<?php

namespace App\model;

class section
{
    private int $pageId;
    private int $sectionId;
    private string $type;
    private string $heading;
    private string $subtitle;
    private array $list;
    private string $linkText;

    public const TYPE_HEADER = 'header';
    public const TYPE_INTRODUCTION = 'introduction';
    public const TYPE_SUBSECTION = 'subsection';
    public const TYPE_PHOTOSECTION = 'photosection';
    public const TYPE_LIST = 'list';
    public const TYPE_TIMETABLE= 'timetable';

    public const TYPE_MARKETING= 'marketing';


    public function getPageId(): int
    {
        return $this->pageId;
    }

    public function setPageId(int $pageId): void
    {
        $this->pageId = $pageId;
    }

    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    public function setSectionId(int $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function setHeading(string $heading): void
    {
        $this->heading = $heading;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function setList(array $list): void
    {
        $this->list = $list;
    }

    public function getLinkText(): string
    {
        return $this->linkText;
    }

    public function setLinkText(string $linkText): void
    {
        $this->linkText = $linkText;
    }
}