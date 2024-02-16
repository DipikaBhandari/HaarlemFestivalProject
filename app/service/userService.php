<?php

namespace App\service;

use App\Repositories\userRepository;

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
}