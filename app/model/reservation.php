<?php

namespace App\model;

class reservation
{
    private $eventName;
    private $date;
    private $startTime;
    private $endTime;
    private $specialRequest;
    private $numberOfTickets;
    private $price;
    private $status;
    private $restaurantSectionId;
    public $userId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }


    /**
     * @return mixed
     */
    public function getRestaurantSectionId()
    {
        return $this->restaurantSectionId;
    }

    /**
     * @param mixed $restaurantSectionId
     */
    public function setRestaurantSectionId($restaurantSectionId): void
    {
        $this->restaurantSectionId = $restaurantSectionId;
    }

    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param mixed $eventName
     */
    public function setEventName($eventName): void
    {
        $this->eventName = $eventName;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return mixed
     */
    public function getSpecialRequest()
    {
        return $this->specialRequest;
    }

    /**
     * @param mixed $specialRequest
     */
    public function setSpecialRequest($specialRequest): void
    {
        $this->specialRequest = $specialRequest;
    }

    /**
     * @return mixed
     */
    public function getNumberOfTickets()
    {
        return $this->numberOfTickets;
    }

    /**
     * @param mixed $numberOfTickets
     */
    public function setNumberOfTickets($numberOfTickets): void
    {
        $this->numberOfTickets = $numberOfTickets;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }
    public function calculatePrice()
    {
        // Price is fixed at 10 euros per ticket
        return $this->numberOfTickets * 10;
    }
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}