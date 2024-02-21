<?php

namespace App\Repositories;
use PDO;
use App\Model\User;
class userRepository extends Repository
{
    public function updateUser(User $user)
    {
        $sql = "UPDATE [dbo].[User] SET username = ?, address = ?, phonenumber = ?, profile_picture = ? WHERE email = ?";
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
            $user->setProfilePicture($userData['profile_picture']);
            return $user;
        }
        return null;
    }
}