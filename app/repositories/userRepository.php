<?php

namespace App\Repositories;
use App\Model\User;
use PDO;
class userRepository extends Repository
{
    public function verifyUser($username, $password)
    {
        try {
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $userArray = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userArray && password_verify($password, $userArray['password'])) {
                $user = new user();
                $user->setUsername($userArray['username']);
                $user->setPassword($userArray['password']);
                $user->setEmail($userArray['email']);
                return $user;
            }

        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Error verifying user: " . $e->getMessage();
        }
        return null;
    }
}