<?php

namespace App\model;

class restaurant
{

    private string $email;
    private $location;
    private string $restaurantName;
    private $phoneNumber;
    private int $numberOfSeats;

    private string $kidPrice;
    private string $adultPrice;

    private string $Picture;

    private string $FoodOfferings;
     private string $Description;

    public function getPicture(): string
    {
        return $this->Picture;
    }

    public function setPicture(string $Picture): void
    {
        $this->Picture = $Picture;
    }

    public function getFoodOfferings(): string
    {
        return $this->FoodOfferings;
    }

    public function setFoodOfferings(string $FoodOfferings): void
    {
        $this->FoodOfferings = $FoodOfferings;
    }

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }

    public function getKidPrice(): string
    {
        return $this->kidPrice;
    }

    public function setKidPrice(string $kidPrice): void
    {
        $this->kidPrice = $kidPrice;
    }

    public function getAdultPrice(): string
    {
        return $this->adultPrice;
    }

    public function setAdultPrice(string $adultPrice): void
    {
        $this->adultPrice = $adultPrice;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    public function getRestaurantName(): string
    {
        return $this->restaurantName;
    }

    public function setRestaurantName(string $restaurantName): void
    {
        $this->restaurantName = $restaurantName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getNumberOfSeats(): int
    {
        return $this->numberOfSeats;
    }

    public function setNumberOfSeats(int $numberOfSeats): void
    {
        $this->numberOfSeats = $numberOfSeats;
    }


}