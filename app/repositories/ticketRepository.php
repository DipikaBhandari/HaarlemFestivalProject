<?php

namespace App\Repositories;

use App\model\Roles;
use PDO;

class ticketRepository extends Repository
{
    public function getOrderByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT orderItemId, eventName, price, numberOfTickets FROM [orderItem] WHERE userId = :userId AND status = 'unpaid';");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_CLASS, 'App\model\orderItem');

            return $orders; // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function PaidOrders($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT orderItemId, eventName, price, numberOfTickets, date, startTime, endTime FROM [orderItem] WHERE userId = :userId AND status = 'paid';");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_CLASS, 'App\model\orderItem');

            return $orders; // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function DisplayEventsByUser($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT orderItemId, eventName, numberOfTickets, date, startTime, endTime, status FROM [orderItem] WHERE userId = :userId;");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $orderItems = $stmt->fetchAll(PDO::FETCH_CLASS, 'App\model\orderItem');

            return $orderItems; // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function getOrderItemsByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [orderItem] WHERE userId = :userId;");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
//            $articles = $stmt->fetchAll(PDO::FETCH_CLASS, 'App\Models\Article');
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $orders; // Return the fetched orders

        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function createOrderItem($newOrderItem)
    {
        try
        {
        $stmt = $this->connection->prepare("INSERT INTO [orderItem] (userId, eventName, date, startTime, endTime, numberOfTickets, price, status) 
            VALUES (:userId, :eventName, :date, :startTime, :endTime, :numberOfTickets, :price, 'unpaid')");

        // Bind parameters
//        $stmt->bindValue(':orderId', $newOrderItem["orderId"]);
//        $stmt->bindParam(':orderId', $orderId);
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
    public function updateTotalPrice($userId)
    {
        $stmt = $this->connection->prepare("SELECT SUM(price) AS totalPrice FROM [orderItem] WHERE userId = :userId AND status ='unpaid'");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update the total price in the Order table
        if ($result && isset($result['totalPrice'])) {
            $totalPrice = $result['totalPrice'];
            $updateStmt = $this->connection->prepare("UPDATE [Order] SET totalPrice = :totalPrice WHERE customerId = :customerId");
            $updateStmt->bindParam(':totalPrice', $totalPrice);
            $updateStmt->bindParam(':customerId', $userId);
            $updateStmt->execute();

        } else {
            echo "No order items found for orderId: $userId";
        }
    }


    public function updateQuantity($orderItemId, $numberOfTickets)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE orderitem SET numberOfTickets = :numberOfTickets WHERE orderItemId = :orderItemId");
            $stmt->bindParam(':numberOfTickets', $numberOfTickets);
            $stmt->bindParam(':orderItemId', $orderItemId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle any exceptions or errors that occurred during the update
            error_log("Error updating quantity: " . $e->getMessage());
            return false;
        }
    }
    public function getOrderPriceById($orderId)
    {
        // Assuming $this->db is your database connection object
        $query = "SELECT price FROM [orderItem] WHERE orderItemId = :orderItemId";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':orderItemId', $orderId);
        $statement->execute();

        // Fetch the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if a result was found
        if ($result) {
            return $result['price'];
        } else {
            // Handle case where order ID is not found
            return null;
        }
    }

    public function updatePrice($orderItemId, $price)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE orderitem SET price = :price WHERE orderItemId = :orderItemId");
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':orderItemId', $orderItemId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle any exceptions or errors that occurred during the update
            error_log("Error updating quantity: " . $e->getMessage());
            return false;
        }
    }
    public function isNewOrderCreated($userId): bool
    {
        // Query the database to check if there are any existing orders for the user
        $sql = "SELECT COUNT(*) FROM [Order] WHERE customerId = :customerId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':customerId', $userId);
        $stmt->execute();

        // Fetch the count of existing orders
        $orderCount = $stmt->fetchColumn();

        // If the count is greater than 0, an order already exists for the user
        return ($orderCount > 0);
    }

    public function createNewOrder($userId): int
    {
        // Check if an order already exists for the user
        if (!$this->isNewOrderCreated($userId)) {
            // Insert new order into the database
            $sql = "INSERT INTO [Order] (customerId) VALUES (:customerId)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':customerId', $userId);
            $stmt->execute();

            // Return the ID of the newly created order
            $orderId = $this->connection->lastInsertId();

            // Set $_SESSION['orderId'] to the retrieved orderId
            $_SESSION['orderId'] = $orderId;

            return $orderId;
        } else {
            // If an order already exists for the user, return the existing order ID
            return $_SESSION['orderId'];
        }
    }
    public function updateOrderPrice($totalPrice, $userId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Order SET totalPrice = :totalPrice WHERE customerId = :customerId");
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':customerId', $userId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle any exceptions or errors that occurred during the update
            error_log("Error updating quantity: " . $e->getMessage());
            return false;
        }
    }


    public function deleteOrderbyOrderId($orderItemId)
    {
        $stmt = $this->connection->prepare("DELETE FROM [orderItem] WHERE orderItemId = :orderItemId");
        $stmt->bindParam(':orderItemId', $orderItemId);
        $stmt->execute();
    }

    public function getOrderIdByCustomerId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT orderId FROM [Order] WHERE customerId = :customerId;");
            $stmt->bindValue(':customerId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
            return $result['orderId']; // Return the orderId from the fetched row
        } catch (PDOException $e) {
            // Handle the exception here
            // For example, you could log the error message and return null
            error_log("Error fetching order for user ID $userId: " . $e->getMessage());
            return null;
        }
    }

    public function getTotalPrice($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT totalPrice FROM [Order] WHERE customerId = :customerId;");
            $stmt->bindParam(':customerId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetching the result as an associative array
            if ($result) {
                return $result['totalPrice']; // Returning the total price fetched from the database
            } else {
                return 0; // Return 0 if no total price found
            }
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

    public function getPaymentIdByOrderId($orderId)
    {

        try {
            // Cast $orderId to an integer to ensure it's handled correctly
            $orderId = (int)$orderId;

            $stmt = $this->connection->prepare('SELECT paymentId FROM payment WHERE orderId = :orderId AND paymentStatus = \'open\'');
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['paymentId'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }



    public function insertPaymentDetail($userId, $orderId, string $status, string $paymentCode, ?string $checkoutUrl)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO payment (userId, orderId, paymentStatus, paymentCode, webhookURL, paymentDate) VALUES (:userId, :orderId, :paymentStatus, :paymentCode, :webhookURL, :paymentDate)");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':orderId', $orderId);
            $stmt->bindParam(':paymentStatus', $status);
            $stmt->bindParam(':paymentCode', $paymentCode);
            $stmt->bindParam(':webhookURL', $checkoutUrl); // Corrected parameter name
            date_default_timezone_set("Europe/Amsterdam");
            $today = date("Y-m-d H:i:s");
            $stmt->bindParam(':paymentDate', $today);
            $stmt->execute();
            return $this->connection->lastInsertId();

        } catch (PDOException $e) {
            // Handle the error
            echo "Error inserting payment detail: " . $e->getMessage();
        }
    }

    public function getCheckoutUrl($orderId)
    {
        try {
            $paymentStatus = "open"; // Variable to hold the payment status

            $stmt = $this->connection->prepare('SELECT webhookURL FROM [payment] WHERE orderId = :orderId AND paymentStatus = :paymentStatus');
            $stmt->bindParam(':orderId', $orderId);
            $stmt->bindParam(':paymentStatus', $paymentStatus); // Binding the variable
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['webhookURL'];
            } else {
                return null; // No record found
            }
        } catch (PDOException $e) {
            // Handle the exception by throwing a new Exception
            throw new Exception('Error fetching checkout URL: ' . $e->getMessage());
        }
    }



    public function updatePaymentStatus($paymentCode, $newPaymentStatus)
    {
        $stmt = $this->connection->prepare('UPDATE [payment] SET paymentStatus = :paymentStatus WHERE paymentCode = :paymentCode');
        $stmt->bindParam(':paymentStatus', $newPaymentStatus);
        $stmt->bindParam(':paymentCode', $paymentCode);
        $stmt->execute();
    }

    public function updateOrderItemStatus($status, $orderId, $userId)
    {
        $stmt = $this->connection->prepare('UPDATE [orderItem] SET status = :status, orderId = :orderId WHERE  userId = :userId');
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function updateOrderId($userId, $orderId)
    {
        $stmt = $this->connection->prepare('UPDATE [orderItem] SET orderId = :orderId WHERE  userId = :userId');
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
    }

    public function getPaymentCode($orderId)
    {
        try {
            $stmt = $this->connection->prepare('SELECT paymentCode FROM payment WHERE orderId = :orderId');
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['paymentCode'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function closeOrder($orderId, $status){
        try {
            $stmt = $this->connection->prepare("UPDATE [orderItem] SET status = :status WHERE orderId = :orderId");
            $stmt->bindParam(':status', $status);

            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}