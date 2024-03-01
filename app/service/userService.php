<?php

namespace App\service;
use App\Repositories\userRepository;
use App\Model\User;


class userService
{
    private $userRepository;

    private $emailService;

    public function __construct()
    {
        $this->userRepository = new userRepository();
        $this->emailService = new emailService();
    }

    public function authenticateUser($username, $password)
    {

        $user = $this->userRepository->verifyUser($username, $password);
        if ($user) {

            return $user;
        }
        return null;
    }

    public function sendResetLink($email){
        $resetToken = $this->userRepository->sendResetLink($email);
        if ($resetToken){
            $result = $this->emailService->sendPasswordResetEmail($email, $resetToken);
            return $result;
        } else{
            return false;
        }
    }

    public function validateToken($token, $email)
    {
        return $this->userRepository->validateToken($token, $email);
    }

    public function updatePassword($email, $password)
    {
        return $this->userRepository->updatePassword($email, $password);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }
    public function updateUser(User $user)
    {
        return $this->userRepository->updateUser($user);
    }
    public function verifyPassword($email, $currentPassword): bool
    {
        // Fetch the user's hashed password from the database using their email
        $user = $this->userRepository->getUserByEmail($email);
        if ($user && password_verify($currentPassword, $user->getPassword())) {
            // The current password is correct
            return true;
        }
        // The current password is incorrect
        return false;
    }
    public function updateUserPassword($email, $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->userRepository->updateUserPasswordByEmail($email, $hashedPassword);
    }
}

