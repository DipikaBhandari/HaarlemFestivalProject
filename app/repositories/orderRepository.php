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
}