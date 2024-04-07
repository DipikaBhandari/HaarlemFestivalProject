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


    public function finalizeOrder($orderId)
    {
        error_log("finalizeOrder is being called");
        try {
            $currentDateTime = date('Y-m-d H:i:s');
            $invoiceNr = $this->generateInvoiceNr($orderId, $currentDateTime);
            $vatAmount = $this->calculateVatAmount($orderId);

            // Prepare the SQL query
            $stmt = $this->connection->prepare('UPDATE [Order] SET dateOfOrder = :dateOfOrder, vatAmount = :vatAmount, invoiceNr = :invoiceNr WHERE orderId = :orderId');

            // Bind parameters
            $stmt->bindParam(':orderId', $orderId);
            $stmt->bindParam(':dateOfOrder', $currentDateTime);
            $stmt->bindParam(':vatAmount', $vatAmount);
            $stmt->bindParam(':invoiceNr', $invoiceNr);

            // Execute the query
            $stmt->execute();

            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return true; // Order finalized successfully
            } else {
                // No rows were affected, handle this case
                error_log("No rows were affected while finalizing the order");
                return false;
            }
        } catch (PDOException $e) {
            // Handle any exceptions or errors that occurred
            error_log("An error occurred while finalizing the order: " . $e->getMessage());
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
            $stmt = $this->connection->prepare('SELECT eventName, numberOfTickets, price, vatPercentage FROM orderItem WHERE orderId = :orderId');
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

    public function getOrderItemsIdByOrder($orderId)
    {
        try {
            $stmt = $this->connection->prepare('SELECT orderItemId FROM orderItem WHERE orderId = :orderId');
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("An error occurred while retrieving the orderItems: " . $e->getMessage());
            return null;
        }
    }

    public function addQRHash($orderId)
    {
        try {
            $orderItems = $this->getOrderItemsIdByOrder($orderId);
            foreach ($orderItems as $orderItemId) {
                $orderItem = $this->getHashData($orderItemId);
                $dataToHash = $orderItemId . $orderItem['userId'] . $orderItem['eventName'];
                $qrHash = hash('sha256', $dataToHash);

                $stmt = $this->connection->prepare('UPDATE orderItem SET qrHash = :qrHash WHERE orderItemId = :orderItemId');
                $stmt->bindParam(':qrHash', $qrHash);
                $stmt->bindParam(':orderItemId', $orderItemId);
                $stmt->execute();
            }
        }catch (PDOException $e) {
            error_log("An error occurred while adding hash to orderItems: " . $e->getMessage());
            return null;
        }
    }

    private function getHashData($orderItemId)
    {
        try {
            $stmt = $this->connection->prepare('SELECT userId, eventName FROM orderItem WHERE orderItemId = :orderItemId');
            $stmt->bindParam(':orderItemId', $orderItemId);
            $stmt->execute();

           return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("An error occurred while retrieving the orderItems: " . $e->getMessage());
            return null;
        }
    }

    private function generateInvoiceNr($orderId, $orderDate)
    {
        // Format the order date as required (e.g., YYYYMMDD)
        $formattedOrderDate = date('Ymd', strtotime($orderDate));

        // Generate the invoice number using the formatted date and orderId
        $invoiceNumber = "INV-$formattedOrderDate-$orderId";
        return $invoiceNumber;
    }

    private function calculateVatAmount($orderId)
    {
        try {
            // Initialize total VAT amount
            $totalVatAmount = 0;

            // Get order items for the given order
            $orderItems = $this->getOrderItems($orderId);

            // Loop through each order item and calculate VAT amount
            foreach ($orderItems as $orderItem) {
                // Calculate VAT amount for the current order item
                $vatAmount = ($orderItem['price'] * $orderItem['vatPercentage']) / 100;

                // Add the VAT amount to the total
                $totalVatAmount += $vatAmount;
            }

            return $totalVatAmount;
        } catch (PDOException $e) {
            error_log("An error occurred while calculating VAT amount: " . $e->getMessage());
            return 0;
        }
    }
}