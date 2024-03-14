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

        $paragraphs = $this->getParagraphsBySection($sectionId);

        $images = $this->getImagesBySection($sectionId);

        return [
            'section' => $section,
            'paragraphs' => $paragraphs,
            'images' => $images
        ];

    }

    public function getParagraphsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Paragraph WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateParagraph($paragraph, $paragraphId)
    {
        $stmt = $this->connection->prepare("UPDATE Paragraph SET text = :text WHERE paragraphId = :paragraphId");
        $stmt->bindParam(':text', $paragraph);
        $stmt->bindParam(':paragraphId', $paragraphId);
        $stmt->execute();
    }

    public function addParagraph($paragraph, $sectionId)
    {
        $stmt = $this->connection->prepare("INSERT INTO Paragraph (sectionId, text) VALUES (:sectionId, :text)");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->bindParam(':text', $paragraph);
        $stmt->execute();
    }

    public function updateSection($sectionId, $heading, $subTitle)
    {
        $stmt = $this->connection->prepare("UPDATE Sections SET heading = :heading, subTitle = :subTitle WHERE sectionId = :sectionId");
        $stmt->bindParam(':heading', $heading);
        $stmt->bindParam(':subTitle', $subTitle);
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();
    }

    public function updateImage($imageId, $imagePath)
    {
        $stmt = $this->connection->prepare("UPDATE Images SET imagePath = :imagePath WHERE imageId = :imageId");
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->bindParam(':imageId', $imageId);
        $stmt->execute();
    }

    public function addImage($sectionId, $imageName, $imagePath)
    {
        $stmt = $this->connection->prepare("INSERT INTO Images (sectionId, imageName, imagePath) VALUES (:sectionId, :imageName, :imagePath)");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->bindParam(':imageName', $imageName);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->execute();
    }

    public function getImagesBySection($sectionId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Images WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImageById($imageId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Images WHERE imageId = :imageId");
        $stmt->bindParam(':imageId', $imageId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSectionTypes()
    {
        $stmt = $this->connection->prepare("SELECT DISTINCT type FROM Sections WHERE type NOT IN ('card', 'crossnavigation','marketing', 'timetable')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPage($pageTitle, $pageLink)
    {
        $stmt = $this->connection->prepare("INSERT INTO Pages (pageTitle, pageLink) VALUES (:pageTitle, :pageLink)");
        $stmt->bindParam(':pageTitle', $pageTitle);
        $stmt->bindParam(':pageLink', $pageLink);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function addSection($pageId, $sectionType, $heading, $subTitle)
    {
        $stmt = $this->connection->prepare("INSERT INTO Sections (pageId, type, heading, subTitle) VALUES (:pageId, :sectionType, :heading, :subTitle)");
        $stmt->bindParam(':pageId', $pageId);
        $stmt->bindParam(':sectionType', $sectionType);
        $stmt->bindParam(':heading', $heading);
        $stmt->bindParam(':subTitle', $subTitle);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function deleteSection($sectionId)
    {
        try {
            $this->deleteParagraphsBySection($sectionId);
            $this->deleteImagesBySection($sectionId);
            $this->deleteSectionById($sectionId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteParagraphsBySection($sectionId)
    {
        $stmt = $this->connection->prepare("DELETE FROM Paragraph WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();
    }

    private function deleteImagesBySection($sectionId)
    {
        $stmt = $this->connection->prepare("DELETE FROM Images WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();
    }

    private function deleteSectionById($sectionId)
    {
        $stmt = $this->connection->prepare("DELETE FROM Sections WHERE sectionId = :sectionId");
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();
    }

    public function deletePage($pageId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Pages WHERE pageId = :pageId");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->execute();
            return true;
        } catch(\Exception $e){
            return false;
        }

    }

    public function getPageByLink($pageLink)
    {
        $stmt = $this->connection->prepare("SELECT pageId FROM Pages WHERE pageLink = :pageLink");
        $stmt->bindParam(':pageLink', $pageLink);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['pageId'];
        } else {
            return null;
        }
    }

    public function nav()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Pages WHERE pageLink IS NOT NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}