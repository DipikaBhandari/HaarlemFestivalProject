<?php

namespace App\model;

class ticket
{
    private int $orderId;
    private String $eventName;
    private \DateTime $date;
    private \DateTime $startTime;
    private \DateTime $endTime;
    private int $numberOfTickets;
    private int $price;
    private string $status;
    private User $userId;

    // Getter and Setter for orderId
    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    // Getter and Setter for eventName
    public function getEventName()
    {
        return $this->eventName;
    }

    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    // Getter and Setter for date
    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    // Getter and Setter for startTime
    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    // Getter and Setter for endTime
    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    // Getter and Setter for numberOfTickets
    public function getNumberOfTickets()
    {
        return $this->numberOfTickets;
    }

    public function setNumberOfTickets($numberOfTickets)
    {
        $this->numberOfTickets = $numberOfTickets;
    }

    // Getter and Setter for price
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    // Getter and Setter for status
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Getter and Setter for userId
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
}
