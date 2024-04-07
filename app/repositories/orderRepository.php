<?php

namespace App\Repositories;


namespace App\Repositories;
use Exception;
use PDO;

class orderRepository extends Repository
{

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