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
        $stmt = $this->connection->prepare("SELECT * FROM Yummyyy WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($restaurantId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Yummyyy WHERE restaurantId = :restaurantId");
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
        $stmt = $this->connection->prepare("SELECT * FROM Yummyyy");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findDetail(int $restaurantId): ?Restaurant
    {
        $stmt = $this->connection->prepare("SELECT * FROM Yummyyy WHERE restaurantId = :restaurantId");
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
    public function updateRestaurantDetails($restaurantDetails)
    {
        $sql = "UPDATE RestaurantSection SET 
                    location = :location, 
                    email = :email, 
                    phonenumber = :phonenumber, 
                    kidPrice = :kidPrice, 
                    adultPrice = :adultPrice, 
                    restaurantName = :restaurantName, 
                    numberOfSeats = :numberOfSeats
                WHERE restaurantId = :restaurantId";

            $stmt = $this->connection->prepare($sql);

            // Convert prices to float and trim any whitespace
            $kidPrice = floatval(str_replace(' ', '', $restaurantDetails['kidPrice']));
            $adultPrice = floatval(str_replace(' ', '', $restaurantDetails['adultPrice']));

            // Bind values to the statement
            $stmt->bindValue(':location', $restaurantDetails['location'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $restaurantDetails['email'], PDO::PARAM_STR);
            $stmt->bindValue(':phonenumber', $restaurantDetails['phoneNumber'] ?? null, $restaurantDetails['phoneNumber'] ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':kidPrice', $kidPrice);
            $stmt->bindValue(':adultPrice', $adultPrice);
            $stmt->bindValue(':restaurantName', $restaurantDetails['restaurantName'], PDO::PARAM_STR);
            $stmt->bindValue(':numberOfSeats', $restaurantDetails['numberOfSeats'], PDO::PARAM_INT);
            $stmt->bindValue(':restaurantId', $restaurantDetails['restaurantId'], PDO::PARAM_INT);

            $stmt->execute();
            return true;
    }
    public function create($restaurantData)
    {
        try {
            $sql = "INSERT INTO [Yummyyy] (sectionId,restaurantName, location, email, kidPrice, adultPrice, numberOfSeats) VALUES (:sectionId, :restaurantName, :location, :email, :kidPrice, :adultPrice, :numberOfSeats)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':sectionId', $restaurantData['sectionId'], PDO::PARAM_INT);
            $stmt->bindParam(':restaurantName', $restaurantData['restaurantName']);
            $stmt->bindParam(':location', $restaurantData['location']);
            $stmt->bindParam(':email', $restaurantData['email']);
            $stmt->bindValue(':kidPrice', number_format((float)$restaurantData['kidPrice'], 2, '.', ''));
            $stmt->bindValue(':adultPrice', number_format((float)$restaurantData['adultPrice'], 2, '.', ''));
            $stmt->bindParam(':numberOfSeats', $restaurantData['numberOfSeats']);

            $stmt->execute();
            return ['success' => true];// Returns the ID of the last inserted row
        } catch (\PDOException $e) {
            // Handle error appropriately
            error_log('SQL error: ' . $e->getMessage(), 0);
            return  ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
