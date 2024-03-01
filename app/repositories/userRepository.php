<?php

namespace App\Repositories;
use PDO;
use App\Model\User;
class userRepository extends Repository
{
    public function updateUser(User $user)
    {
        $sql = "UPDATE [dbo].[User] SET username = ?, address = ?, phonenumber = ?, picture = COALESCE(?, picture) WHERE email = ?";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                $user->getName(),
                $user->getAddress(),
                $user->getPhoneNumber(),
                $user->getProfilePicture(),
                $user->getEmail(),

            ]);

            return true;
        } catch (\PDOException $e) {
            // Handle error appropriately
            print("Error updating user by email: " . $e->getMessage());
            return false;
        }
    }
    public function findByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM [dbo].[User] WHERE email = ?");
        $stmt->execute([$email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Convert the array to a User object and return it
            $user = new User();
            $user->setName($userData['username']);
            $user->setEmail($userData['email']);
            $user->setAddress($userData['address']);
            $user->setPhoneNumber($userData['phonenumber']);
            $user->setPassword($userData['password']);
            $user->setProfilePicture($userData['picture']);
            return $user;
        }
        return null;
    }
    public function getUserByEmail($email): ?User {
        try {
            $sql = "SELECT * FROM [User] WHERE email = :email";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            $userArray = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($userArray) {
                $user = new User();
                // Set other required attributes of the User model
                $user->setPassword($userArray['password']);
                return $user;
            }
        } catch (PDOException $e) {
            // Handle the error properly
            error_log($e->getMessage());
            // Depending on your error handling strategy, you might want to show an error or log it.
        }
        return null;
    }
    public function updateUserPasswordByEmail($email, $hashedPassword): bool {
        $sql = "UPDATE [dbo].[User] SET password = ? WHERE email = ?";
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([$hashedPassword, $email]);
        } catch (\PDOException $e) {
            // Handle error appropriately
            return false;
        }
    }
}


