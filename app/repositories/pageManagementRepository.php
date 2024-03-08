<?php

namespace App\Repositories;
use PDO;

class pageManagementRepository extends Repository
{
    public function getAllPages(){
        $stmt = $this->connection->prepare("SELECT * FROM Pages");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSectionsByPage($pageId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Sections WHERE pageId = :pageId");
        $stmt->bindParam(':pageId', $pageId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageTitle($pageId)
    {
        $stmt = $this->connection->prepare("SELECT pageTitle FROM pages WHERE pageId = :pageId");
        $stmt->bindParam(':pageId', $pageId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['pageTitle'];
        } else {
            return null;
        }
    }

    public function getSectionContent($sectionId)
    {
        $sectionStmt = $this->connection->prepare("SELECT * FROM Sections WHERE sectionId = :sectionId");
        $sectionStmt->bindParam(':sectionId', $sectionId);
        $sectionStmt->execute();
        $section = $sectionStmt->fetch(PDO::FETCH_ASSOC);

        $paragraphStmt = $this->connection->prepare("SELECT * FROM Paragraph WHERE sectionId = :sectionId");
        $paragraphStmt->bindParam(':sectionId', $sectionId);
        $paragraphStmt->execute();
        $paragraphs = $paragraphStmt->fetchAll(PDO::FETCH_ASSOC);

        $imageStmt = $this->connection->prepare("SELECT * FROM Images WHERE sectionId = :sectionId");
        $imageStmt->bindParam(':sectionId', $sectionId);
        $imageStmt->execute();
        $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'section' => $section,
            'paragraphs' => $paragraphs,
            'images' => $images
        ];

    }
}