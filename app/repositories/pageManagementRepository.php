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
        $stmt = $this->connection->prepare("SELECT * FROM Sections LEFT JOIN Paragraph ON Sections.sectionId = Paragraph.sectionId LEFT JOIN Images ON Sections.sectionId = Images.sectionId WHERE Sections.sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}