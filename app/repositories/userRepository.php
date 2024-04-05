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
            $sql = "SELECT * FROM [User] WHERE username = :username";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $userArray = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userArray && password_verify($password, $userArray['password'])) {
                $user = new user();
                $user->setUsername($userArray['username']);
                $user->setPassword($userArray['password']);
                $user->setEmail($userArray['email']);
                $user->setRole($userArray['role']);
                $user->setUserId($userArray['id']);
                return $user;
            }

        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Error verifying user: " . $e->getMessage();
        }
        return null;
    }

    public function sendResetLink($email){
        $sql = "SELECT * FROM [User] WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $userArray = $stmt->fetch(PDO::FETCH_ASSOC);
        if($userArray){
            $resetToken = bin2hex(random_bytes(32));
            $resetTokenHash = password_hash($resetToken, PASSWORD_DEFAULT);
            $resetTokenExpiration = time() + (24 * 60 * 60);
            $expirationDate = date('Y-m-d H:i:s', $resetTokenExpiration);

            $updateSql = "UPDATE [User] SET reset_token_hash = :resetTokenHash, reset_token_expires_at = :reset_token_expires_at WHERE email = :email";
            $updateStmt = $this->connection->prepare($updateSql);

            $updateStmt->bindParam(':resetTokenHash', $resetTokenHash);
            $updateStmt->bindParam(':reset_token_expires_at', $expirationDate);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();

            return $resetToken;
        } else {
            return false;
        }
    }

    public function validateToken($token, $email)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "SELECT reset_token_hash FROM [User] WHERE email = :email AND reset_token_expires_at > :currentDateTime";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':currentDateTime', $currentDateTime);
        $stmt->execute();

        $userArray = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userArray && password_verify($token, $userArray['reset_token_hash'])){
            return true;
        } else{
            return false;
        }
    }

    public function updatePassword($email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $currentTime = date('Y-m-d H:i:s');
        $sql = "UPDATE [User] SET password = :hashedPassword, reset_token_expires_at = :currentTime WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':currentTime', $currentTime);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }



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


    public function registerUser($newUser): bool
    {
        try {
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

            $userId=$this->connection->lastInsertId(); // Get the newly inserted user ID

//             Create a new order for the user
//            $orderId = $this->createNewOrder($userId);
//
//            // Store order ID and user ID in session
//            $_SESSION['userId'] = $userId;
//            $_SESSION['orderId'] = $orderId;

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //
    public function createNewOrder($userId): int
    {
        // Insert new order into the database
        $sql = "INSERT INTO [Order] (customerId) VALUES (:customerId)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':customerId', $userId);
        $stmt->execute();

        // Return the ID of the newly created order
        $orderId = $this->connection->lastInsertId();

        // Set $_SESSION['orderId'] to the retrieved orderId
        $_SESSION['orderId'] = $orderId;

        return $orderId;
    }
    public function updateOrderTableWithNewUserId($customerId, $orderId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE [dbo].[Order] SET customerId = :customerId WHERE orderId = :orderId");
            $stmt->bindValue(':customerId', $customerId);
            $stmt->bindValue(':orderId', $orderId);
            $stmt->execute();

            // Check if the update was successful
            if ($stmt->rowCount() == 0) {
                return false;
            } else {
                // Unset the session variable to expire it
                unset($_SESSION['orderId']);
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}

