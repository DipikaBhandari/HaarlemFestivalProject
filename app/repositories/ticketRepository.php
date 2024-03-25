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

    public function createOrderItem($newOrderItem, $orderId)
    {
        try
        {
        $stmt = $this->connection->prepare("INSERT INTO [orderItem] (orderId, userId, eventName, date, startTime, endTime, numberOfTickets, price, status) 
            VALUES (:orderId, :userId, :eventName, :date, :startTime, :endTime, :numberOfTickets, :price, 'unpaid')");

        // Bind parameters
//        $stmt->bindValue(':orderId', $newOrderItem["orderId"]);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindValue(':userId', $newOrderItem["userId"]);
        $stmt->bindValue(':eventName', $newOrderItem["eventName"]);
        $stmt->bindValue(':date', $newOrderItem["date"]);
        $stmt->bindValue(':startTime', $newOrderItem["startTime"]);
        $stmt->bindValue(':endTime', $newOrderItem['endTime']);
        $stmt->bindValue(':numberOfTickets', $newOrderItem['numberOfTickets']);
        $stmt->bindValue(':price', $newOrderItem['price']);

        $stmt->execute();

        // Return the ID of the newly created order item if needed
        return $this->connection->lastInsertId();
    } catch (PDOException $e) {
        // Handle database errors
        echo $e->getMessage();
        return false;
    }
    }

    public function deleteOrderbyOrderId($orderItemId)
    {
        $stmt = $this->connection->prepare("DELETE FROM [orderItem] WHERE orderItemId = :orderItemId");
        $stmt->bindParam(':orderItemId', $orderItemId);
        $stmt->execute();
    }

    public function getOrderIdByCustomerId($userId): bool|array|null
    {
        try {
            $stmt = $this->connection->prepare("SELECT orderId FROM [Order] WHERE customerId = :customerId;");
            $stmt->bindValue(':customerId', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function getOrderItemIdByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT orderItemId FROM [orderItem] WHERE userId = :userId and status = 'unpaid';");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
//            return $result['orderId'];
            if ($result !== false) {
                return $result['orderItemId'];
            } else {
                return null;
            }

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }
}