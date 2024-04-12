<?php

namespace App\Repositories;
use App\model\restaurant;
use Exception;
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
    public function getYummyImageBySection($restaurantSectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM YummyImage WHERE restaurantSectionId = :restaurantSectionId");
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
        $restaurant->setPicture($data['restaurantPicture']);
        $restaurant->setDescription($data['description']);
        $restaurant->setFoodOfferings($data['foodOfferings']);

        return $restaurant;
    }

    public function updateRestaurantDetails($restaurantId, $data) {
        try {
            $sql = "UPDATE Yummyyy SET 
                    location = :location, 
                    email = :email, 
                    kidPrice = :kidPrice, 
                    adultPrice = :adultPrice, 
                    restaurantName = :restaurantName, 
                    numberOfSeats = :numberOfSeats,
                    description = :description, 
                    foodOfferings = :foodOfferings,
                    restaurantPicture = :restaurantPicture
                    WHERE restaurantId = :restaurantId";

                        $stmt = $this->connection->prepare($sql);

                        // Bind values to the statement
                        $stmt->bindValue(':location', $data['location']);
                        $stmt->bindValue(':email', $data['email']);
                       // $stmt->bindValue(':phoneNumber', $data['phoneNumber']);
                        $stmt->bindValue(':kidPrice', $data['kidPrice']);
                        $stmt->bindValue(':adultPrice', $data['adultPrice']);
                        $stmt->bindValue(':restaurantName', $data['restaurantName']);
                        $stmt->bindValue(':numberOfSeats', $data['numberOfSeats'], PDO::PARAM_INT);
                        $stmt->bindValue(':description', $data['description']);
                        $stmt->bindValue(':foodOfferings', $data['foodOfferings']);
                        $stmt->bindValue(':restaurantPicture', $data['restaurantPicture']);
                        $stmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);


                         // Execute the query
                        if (!$stmt->execute()) {
                            // Handle error appropriately
                            throw new Exception("Database error: " . $stmt->errorInfo()[2]);
                        }
            $sqlSession = "UPDATE Session SET 
                numberOfSeats = :numberOfSeats
                WHERE restaurantId = :restaurantId";

            $stmtSession = $this->connection->prepare($sqlSession);
            $stmtSession->bindValue(':numberOfSeats', $data['numberOfSeats'], PDO::PARAM_INT);
            $stmtSession->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);

            if (!$stmtSession->execute()) {
                throw new Exception("Database error: " . $stmtSession->errorInfo()[2]);
            }

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            // Log error (optional)
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function create($restaurantData)
    {
        try {
            $sql = "INSERT INTO Yummyyy (sectionId, restaurantName, location, email, kidPrice, adultPrice, numberOfSeats, restaurantPicture, description, foodOfferings, phoneNumber) VALUES (:sectionId, :restaurantName, :location, :email, :kidPrice, :adultPrice, :numberOfSeats, :restaurantPicture, :description, :foodOfferings, :phoneNumber)";
            $stmt = $this->connection->prepare($sql);


            $stmt->bindValue(':sectionId', $restaurantData['sectionId'], PDO::PARAM_INT);
            $stmt->bindParam(':restaurantName', $restaurantData['restaurantName']);
            $stmt->bindParam(':location', $restaurantData['location']);
            $stmt->bindParam(':email', $restaurantData['email']);
            $stmt->bindValue(':kidPrice', number_format((float)$restaurantData['kidPrice'], 2, '.', ''), PDO::PARAM_STR);
            $stmt->bindValue(':adultPrice', number_format((float)$restaurantData['adultPrice'], 2, '.', ''), PDO::PARAM_STR);
            $stmt->bindParam(':numberOfSeats', $restaurantData['numberOfSeats'], PDO::PARAM_INT);
            $stmt->bindParam(':restaurantPicture', $restaurantData['imagePath']); // Updated to use the imagePath key
            $stmt->bindParam(':description', $restaurantData['description']);
            $stmt->bindParam(':foodOfferings', $restaurantData['foodOfferings']);
            $stmt->bindParam(':phoneNumber', $restaurantData['phoneNumber']); // Assuming this is handled in the sanitizeRestaurantData method
            //$stmt->bindParam(':eventName', $restaurantData['']);
            $stmt->execute();
            return ['success' => true];// Returns the ID of the last inserted row
        } catch (\PDOException $e) {
            // Handle error appropriately
            error_log('SQL error: ' . $e->getMessage(), 0);
            return  ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public function getSessionById($sessionId) {
        $stmt = $this->connection->prepare("SELECT * FROM Session WHERE sessionId = :sessionId");
        $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateSessionSeats($sessionId, $seatsToDeduct) {
        $session = $this->getSessionById($sessionId);
        if(!$session) {
            throw new Exception('Session not found.');
        }

        $numberOfSeats = $session['numberOfSeats'] - $seatsToDeduct;
        if($session['numberOfSeats'] < $seatsToDeduct) {
            throw new Exception('Not enough seats available.');
        }

        $stmt = $this->connection->prepare("UPDATE Session SET numberOfSeats = :numberOfSeats WHERE sessionId = :sessionId");
        $stmt->bindParam(':numberOfSeats', $numberOfSeats, PDO::PARAM_INT);
        $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function createReservation($orderData, ) {
        $sessionDetails = $this->getSessionById($orderData['session']);
        if (!$sessionDetails) {
            throw new Exception('Session does not exist.');
        }
        $startTime = $sessionDetails['startTime'];
        $endTime = $sessionDetails['endTime'];
        $status= "unpaid";
        $eventName ="Yummy";
        $stmt = $this->connection->prepare("INSERT INTO orderItem (userId, sessionId, startTime,endTime,date, numberOfTickets, price, specialRequest, restaurantSectionId, status, eventName, orderId) VALUES (:userId, :sessionId,:startTime,:endTime, :date, :numberOfTickets, :price, :specialRequest, :restaurantSectionId, :status, :eventName, :orderId)");
        $stmt->bindValue(':userId', $orderData['userId']);
        $stmt->bindValue(':sessionId', $orderData['session']);
        $stmt->bindValue(':startTime', $startTime);
        $stmt->bindValue(':endTime',$endTime);
        $stmt->bindValue(':date', $orderData['date']);
        $stmt->bindValue(':numberOfTickets', $orderData['num_adults'] + $orderData['num_children']);
        $stmt->bindValue(':price', $orderData['price']);
        $stmt->bindValue(':specialRequest', $orderData['special_requests']);
        $stmt->bindValue(':restaurantSectionId', $orderData['restaurantSectionId']);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':eventName', $eventName);
        $stmt->bindValue(':orderId', $orderData['orderId']);


        $stmt->execute();
        return $this->connection->lastInsertId();
    }
    public function getSessionsForRestaurantId($restaurantId) {
        $stmt = $this->connection->prepare("SELECT sessionId, startTime, endTime FROM Session WHERE restaurantId = :restaurantId");
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function deleteRestaurant($restaurantId)
    {
        $sql = "DELETE FROM Yummyyy WHERE restaurantId = :restaurantId";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting restaurant: " . $e->getMessage());
            return false;
        }
    }
}
