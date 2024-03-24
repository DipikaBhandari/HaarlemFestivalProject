<?php

namespace App\Repositories;

class orderRepository extends Repository
{
    public function getTicketWithQRCode($qrHash)
    {
        $stmt = $this->connection->prepare('SELECT * FROM orderItem WHERE qrHash = :qrHash');
        $stmt->bindParam(':qrHash', $qrHash);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateTicketStatus($qrHash, $status) {
        try {
            $stmt = $this->connection->prepare('UPDATE orderItem SET status = :status WHERE qrHash = :qrHash');
            $stmt->bindParam(':qrHash', $qrHash);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return true;
        } catch (\PDOException $e){
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
        } catch (\PDOException $e){
            return false;
        }
    }

    public function getTicketById($orderItemId)
    {
        $stmt = $this->connection->prepare('SELECT oi.eventName, oi.date, oi.startTime, oi.endTime, oi.numberOfTickets, oi.qrHash, u.email, u.firstName, u.lastName FROM orderItem oi JOIN [User] u ON oi.userId = u.id WHERE oi.orderItemId = :orderItemId');
        $stmt->bindParam(':orderItemId', $orderItemId);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getInvoiceData($orderId)
    {
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
    }

    private function getOrderItems($orderId)
    {
        $stmt = $this->connection->prepare('SELECT eventName, numberOfTickets, price FROM orderItem WHERE orderId = :orderId');
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}