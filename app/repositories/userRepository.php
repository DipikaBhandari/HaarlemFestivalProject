<?php

namespace App\Repositories;
use App\model\Roles;
use App\Model\User;
use PDO;
use PDOException;

class userRepository extends Repository
{

    public function verifyUser($username, $password)
    {
        try {

            $sql = "SELECT * FROM [User] WHERE username =:username";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $userArray = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userArray && password_verify($password, $userArray['password'])) {
                $user = new user();
                $user->setUsername($userArray['username']);
                $user->setPassword($userArray['password']);

                return $user;
            }

        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Error verifying user: " . $e->getMessage();
        }
        return null;
    }

    public function registerUser($newUser): bool
    {
        try {
            // Move uploaded file to permanent location

            // Insert user data into the database
            $sql = "INSERT INTO [User] (username, email, address, phonenumber, password, picture, role) 
                VALUES (:username, :email, :address, :phonenumber, :password, :picture, :role)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':username', $newUser["username"]);
            $stmt->bindValue(':email', $newUser["email"]);
            $stmt->bindValue(':address', $newUser["address"]);
            $stmt->bindValue(':phonenumber', $newUser["phonenumber"]);
            $stmt->bindValue(':password', $newUser['password']);
            $stmt->bindValue(':picture', $newUser['picture']);
            $stmt->bindValue(':role', Roles::getLabel($newUser['role']));
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}