<?php

namespace App\Repositories;
use App\model\restaurant;
use PDO;

class restaurantRepository extends Repository
{
    public function getSectionsByPage($pageId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Sections WHERE pageId = :pageId");
        $stmt->bindParam(':pageId', $pageId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Images WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParagraphsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Paragraph WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCarouselItemsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM CarouselItems WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCardItemsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Yummy WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($restaurantId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Yummy WHERE restaurantId = :restaurantId");
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSectionsForRestaurant($restaurantId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM RestaurantSection WHERE restaurantId = :restaurantId");
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getYummyParagraphsBySection($restaurantSectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM YummyParagraph WHERE restaurantSectionId = :restaurantSectionId");
        $stmt->bindParam(':restaurantSectionId', $restaurantSectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getYummyOpeningBySection($restaurantSectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM OpeningTime WHERE restaurantSectionId = :restaurantSectionId");
        $stmt->bindParam(':restaurantSectionId', $restaurantSectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllYummyLocations()
    {
        $stmt = $this->connection->prepare("SELECT * FROM YummyLocation");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllYummyInfo()
    {
        $stmt = $this->connection->prepare("SELECT * FROM RestaurantSection");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findDetail(int $restaurantId): ?Restaurant
    {
        $stmt = $this->connection->prepare("SELECT * FROM RestaurantSection WHERE restaurantId = :restaurantId");
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $restaurant = new Restaurant();
        $restaurant->setEmail($data['email'] ?? '');
        $restaurant->setLocation($data['location']);
        $restaurant->setRestaurantName($data['restaurantName']);
        $restaurant->setPhoneNumber($data['phonenumber']);
        $restaurant->setNumberOfSeats($data['numberOfSeats'] ?? 0); // assuming 'numberOfSeats' is a valid column in your table
        $restaurant->setKidPrice($data['kidPrice']);
        $restaurant->setAdultPrice($data['adultPrice']);

        return $restaurant;
    }
}