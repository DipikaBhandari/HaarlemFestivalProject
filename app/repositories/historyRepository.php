<?php

namespace App\Repositories;

use PDO;
use PDOException;

class historyRepository extends Repository
{

    public function getSectionsByPage($pageId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM [Sections] WHERE pageId = :pageId");
        $stmt->bindParam(':pageId', $pageId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Images WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParagraphsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Paragraph WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLocationBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM HistoryLocations WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistoryDetailsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM HistoryDetails WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGuideName()
    {
        $stmt = $this->connection->prepare("SELECT * FROM HistoryGuide");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCarouselItemsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM CarouselItems WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistoryDetailsWithGuideNames() {
        try {
            $stmt = $this->connection->prepare("
            SELECT HistoryDetails.*, HistoryGuide.guideName
            FROM HistoryDetails
            JOIN HistoryGuide ON HistoryDetails.guideId = HistoryGuide.guideId;
        ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // handle exception
            echo "An error occurred: " . $e->getMessage();
            return [];
        }
    }
    public function fetchAllGuide()
    {
        try {
            $sql = "SELECT * FROM HistoryGuide";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            // Fetch all users as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching all users: " . $e->getMessage());
            return [];
        }
    }

    public function insertHistory($data)
    {
        $section= 22;
        $sql = "INSERT INTO historyDetails (date, time, languageIndicator, guideId, sectionId, startTime, endTime) VALUES (:date, :time, :languageIndicator, :guideId, :sectionId, :startTime, :endTime)";

        try {
            $stmt = $this->connection->prepare($sql);
            // Bind the values from $data to the placeholders
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':time', $data['time']);
            $stmt->bindParam(':languageIndicator', $data['languageIndicator']);
            $stmt->bindParam(':guideId', $data['guideId'], PDO::PARAM_INT);
            $stmt->bindParam(':sectionId', $data['sectionId'], PDO::PARAM_INT);
            $stmt->bindParam(':startTime', $data['startTime']);
            $stmt->bindParam(':endTime', $data['endTime']);

            // Execute the statement
            $stmt->execute();
            // Check if insert was successful
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            // Handle exception
            // Log error and/or return false or a custom error message
            return false;
        }
    }
    public function deleteHistory($historyId)
    {
        $sql = "DELETE FROM historyDetails WHERE historyId = :historyId";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':historyId', $historyId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function getHistoryDetail($historyId)
    {
        try {
            $sql ="SELECT * FROM historyDetails WHERE historyId = :historyId";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('historyId', $historyId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            // Handle the error properly
            error_log($e->getMessage());
        }
    }

    public function updateHistory($data)
    {
        // SQL query to update the history record
        // Ensure your SQL parameters are named correctly according to your database schema
        $sql = "UPDATE historyDetails SET date = :date, time = :time, languageIndicator = :languageIndicator, guideId = :guideId, startTime = :startTime, endTime = :endTime WHERE historyId = :historyId";

        $stmt = $this->connection->prepare($sql);

        // Bind values from $data array to the statement
        $stmt->bindValue(':historyId', $data['historyId'], PDO::PARAM_INT);
        $stmt->bindValue(':date', $data['date']);
        $stmt->bindValue(':time', $data['time']);
        $stmt->bindValue(':languageIndicator', $data['languageIndicator']);
        $stmt->bindValue(':guideId', $data['guideId'], PDO::PARAM_INT);
        $stmt->bindValue(':startTime', $data['startTime']);
        $stmt->bindValue(':endTime', $data['endTime']);

        // Execute the update
        if ($stmt->execute()) {
            return true; // Update succeeded
        } else {
            return false; // Update failed
        }
    }
}