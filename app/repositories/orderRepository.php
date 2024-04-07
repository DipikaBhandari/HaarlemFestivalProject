<?php

namespace App\Repositories;
use PDO;
use PDOException;
class orderRepository extends Repository
{
    public function getTicketWithQRCode($qrHash)
    {
        try{
            $stmt = $this->connection->prepare('SELECT * FROM orderItem WHERE qrHash = :qrHash');
            $stmt->bindParam(':qrHash', $qrHash);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            error_log("An error occurred while retrieving the ticket status" . $e->getMessage());
            return false;
        }
    }

    public function updateTicketStatus($qrHash, $status) {
        try {
            $stmt = $this->connection->prepare('UPDATE orderItem SET status = :status WHERE qrHash = :qrHash');
            $stmt->bindParam(':qrHash', $qrHash);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return true;
        } catch (PDOException $e){
            error_log("An error occurred while updating the ticket status" . $e->getMessage());
            return false;
        }
    }

    public function finalizeOrder($orderId, $orderItem)
    {
        try {
            $stmt = $this->connection->prepare('UPDATE orderItem SET status = :status, orderId = :orderId, qrHash = :qrHash WHERE orderItemId = :orderItemId');
            $stmt->bindParam(':qrHash', $orderItem['qrHash']);
            $stmt->bindParam(':status', $orderItem['status']);
            $stmt->bindParam(':orderId', $orderItem['orderId']);
            $stmt->bindParam(':orderItemId', $orderItem['orderItemId']);
            $stmt->execute();
            return true;
        } catch (PDOException $e){
            error_log("An error occurred while updating the order" . $e->getMessage());
            return false;
        }
    }

    public function getTicketById($orderItemId)
    {
        try{
            $stmt = $this->connection->prepare('SELECT oi.eventName, oi.date, oi.startTime, oi.endTime, oi.numberOfTickets, oi.qrHash, u.email, u.firstName, u.lastName FROM orderItem oi JOIN [User] u ON oi.userId = u.id WHERE oi.orderItemId = :orderItemId');
            $stmt->bindParam(':orderItemId', $orderItemId);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            error_log("An error occurred while retrieving the ticket" . $e->getMessage());
            return null;
        }
    }

    public function getInvoiceData($orderId)
    {
        try{
            $stmt = $this->connection->prepare("SELECT
                o.invoiceNr,
                o.dateOfOrder,
                o.totalPrice,
                o.vatAmount,
                u.firstName,
                u.lastName,
                u.phonenumber,
                u.address,
                u.email
            FROM
                [Order] o
            JOIN
                [User] u ON o.customerId = u.id
            WHERE
                o.orderId = :orderId");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();

            $invoiceData = $stmt->fetch(\PDO::FETCH_ASSOC);
            $orderItems = $this->getOrderItems($orderId);
            $invoiceData['orderItems'] = $orderItems;

            return $invoiceData;
        } catch (PDOException $e){
            error_log("An error occurred while retrieving the invoice data: " . $e->getMessage());
            return null;
        }
    }

    private function getOrderItems($orderId)
    {
        try {
            $stmt = $this->connection->prepare('SELECT eventName, numberOfTickets, price FROM orderItem WHERE orderId = :orderId');
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("An error occurred while retrieving the orderItems: " . $e->getMessage());
            return null;
        }
    }

    public function getOrderDetails() {
        $stmt = $this->connection->prepare("
        SELECT 
            o.dateOfOrder, 
            o.totalPrice, 
            o.invoiceNr,
            u.username
        FROM [dbo].[Order] AS o
        INNER JOIN [dbo].[orderItem] AS oi ON o.orderId = oi.orderId
        INNER JOIN [dbo].[User] AS u ON oi.userId = u.id
        GROUP BY o.dateOfOrder, o.totalPrice, o.invoiceNr, u.username
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}