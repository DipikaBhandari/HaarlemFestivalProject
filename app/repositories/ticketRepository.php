<?php

namespace App\Repositories;

use App\model\Roles;
use PDO;

class ticketRepository extends Repository
{
    public function getOrderByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM `order` WHERE userId = :userId;");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $stmt->fetch(PDO::FETCH_ASSOC);



        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function createOrder($newOrderItem): void
    {
        try {
            $sql = ("INSERT INTO `order` (userId, eventName, date, startTime, endTime, numberOfTickets, status) 
                VALUES (:userId, :eventName,:date, :startTime,:endTime, :numberOfTickets, 'unpaid');");
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':userId', $newOrderItem["username"]);
            $stmt->bindValue(':eventName', $newOrderItem["eventName"]);
            $stmt->bindValue(':date', $newOrderItem["date"]);
            $stmt->bindValue(':startTime', $newOrderItem["startTime"]);
            $stmt->bindValue(':endTime', $newOrderItem['endTime']);
            $stmt->bindValue(':numberOfTickets', $newOrderItem['numberOfTickets']);

            $stmt->execute();


//            $lastInsertedId = $this->connection->lastInsertId();
//            return $lastInsertedId;
        } catch (PDOException $e) {
            // handle the error here, for example:
            echo "Error creating order: " . $e->getMessage();
            // or redirect to an error page
        }
    }
}