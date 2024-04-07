<?php

namespace App\Repositories;
use PDO;
use PDOException;
class homepageRepository extends Repository
{
    public function getSectionsByPage($pageId)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM Sections WHERE pageId = :pageId");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error retrieving sections by page: ' .$e->getMessage());
            return false;
        }
    }

    public function getImagesBySection($sectionId)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM Images WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error retrieving images by section: ' .$e->getMessage());
            return false;
        }
    }

    public function getParagraphsBySection($sectionId)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM Paragraph WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error retrieving paragraphs by section: ' .$e->getMessage());
            return false;
        }
    }

    public function getCarouselItemsBySection($sectionId)
    {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM CarouselItems WHERE sectionId = :sectionId");
            $stmt->bindParam(':sectionId', $sectionId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error retrieving carouselItems: ' .$e->getMessage());
            return false;
        }
    }
}