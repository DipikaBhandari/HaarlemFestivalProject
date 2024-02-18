<?php

namespace App\Repositories;
use PDO;
class homepageRepository extends Repository
{
    public function getAll()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Pages WHERE pageId = :pageId");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\\Model\\User');
        $users = $stmt->fetchAll();

        return $users;
    }
}