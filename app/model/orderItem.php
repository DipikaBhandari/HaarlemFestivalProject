<?php

namespace App\model;

use DateTime;

class orderItem
{

    public string $status;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
    public string $startTime;

    /**
     * @return DateTime
     */


    public string $endTime;

    /**
     * @return string
     */
    public function getEndTime(): string
    {
        return substr($this->endTime, 0, 5);    }

    /**
     * @param string $endTime
     */
    public function setEndTime(string $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return \DateTime
     */


    public string $date;

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }


    public function getStartTime(): string
    {
        return substr($this->startTime, 0, 5);
    }


    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }
    public int $orderItemId;

    /**
     * @return int
     */
    public function getNumberOfTickets(): int
    {
        return $this->numberOfTickets;
    }

    /**
     * @param int $numberOfTickets
     */
    public function setNumberOfTickets(int $numberOfTickets): void
    {
        $this->numberOfTickets = $numberOfTickets;
    }

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    public string $eventName;

    private float $price;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getOrderItemId(): int
    {
        return $this->orderItemId;
    }

    /**
     * @param int $orderItemId
     */
    public function setOrderItemId(int $orderItemId): void
    {
        $this->orderItemId = $orderItemId;
    }

    public int $numberOfTickets;

    public function jsonSerialize():mixed
    {
        return get_object_vars($this);
    }
}