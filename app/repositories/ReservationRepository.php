<?php

namespace App\Repositories;

namespace App\Repositories;
use App\model\reservation;
use Exception;
use PDO;

class ReservationRepository extends  Repository
{
    public function getReservationDetails()
    {
        $stmt = $this->connection->prepare("
             SELECT * FROM orderItem WHERE LOWER(eventName) = 'yummy'
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingleReservationDetails($orderItemId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM orderItem WHERE orderItemId = :orderItemId");
        $stmt->bindParam(':orderItemId', $orderItemId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReservationDetails($reservationData)
    {
        $stmt = $this->connection->prepare("UPDATE orderItem SET eventName = :eventName, date = :date, startTime = :startTime, endTime = :endTime, specialRequest = :specialRequest, numberOfTickets = :numberOfTickets, price = :price, status = :status WHERE orderItemId = :orderItemId");

        // Bind parameters from $reservationData array
        foreach ($reservationData as $key => &$val) {
            $stmt->bindParam(':' . $key, $val);
        }

        return $stmt->execute();
    }

    public function updateReservationStatus($orderItemId, $status)
    {
        $stmt = $this->connection->prepare("UPDATE orderItem SET status = :status WHERE orderItemId = :orderItemId");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':orderItemId', $orderItemId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addNewReservation(reservation $reservation)
    {
        $stmt = $this->connection->prepare(" INSERT INTO orderItem (restaurantSectionId, date, startTime, endTime, numberOfTickets, price, status, specialRequest, eventName, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $reservation->getRestaurantSectionId(),
            $reservation->getDate(),
            $reservation->getStartTime(),
            $reservation->getEndTime(),
            $reservation->getNumberOfTickets(),
            $reservation->calculatePrice(),
            $reservation->getStatus(),
           //  // Assuming this comes from the session or another method
            $reservation->getSpecialRequest(),
            $reservation->getEventName(),
            $reservation->getUserId()
        ]);

        return $this->connection->lastInsertId();
    }



}