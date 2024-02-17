<?php

namespace App\Repositories;
use App\Model\User;
use PDO;
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
}