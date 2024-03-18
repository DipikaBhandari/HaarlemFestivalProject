<?php

namespace App\Repositories;

use App\model\Roles;
use PDO;

class ticketRepository extends Repository
{
    public function getOrderByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [orderItem] WHERE userId = :userId;");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $orders; // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function createOrder($newOrderItem)
    {
            $stmt =  $this->connection->prepare("INSERT INTO [orderItem] (userId, eventName, date, startTime, endTime, numberOfTickets, status) 
                VALUES (:userId, :eventName, :date, :startTime,:endTime, :numberOfTickets, 'unpaid');");

            $stmt->bindValue(':userId', $newOrderItem["userId"]);
            $stmt->bindValue(':eventName', $newOrderItem["eventName"]);
            $stmt->bindValue(':date', $newOrderItem["date"]);
            $stmt->bindValue(':startTime', $newOrderItem["startTime"]);
            $stmt->bindValue(':endTime', $newOrderItem['endTime']);
            $stmt->bindValue(':numberOfTickets', $newOrderItem['numberOfTickets']);
            $stmt->execute();
          return  $this->connection->lastInsertId();
    }

    public function deleteOrderbyOrderId($orderItemId)
    {
        $stmt = $this->connection->prepare("DELETE FROM [orderItem] WHERE orderItemId = :orderItemId");
        $stmt->bindParam(':orderItemId', $orderItemId);
        $stmt->execute();
    }

    public function getOrderByOrderId($orderId): bool|array|null
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [order] WHERE orderId = :orderId;");
            $stmt->bindValue(':orderId', $orderId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }
}