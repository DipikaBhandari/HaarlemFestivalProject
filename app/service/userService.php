<?php

namespace App\service;

use App\Repositories\userRepository;

class userService
{
    private userRepository $userRepository;

    public function authenticateUser($username, $password)
    {
        $user = $this->userRepository->verifyUser($username, $password);
        if ($user) {

            return $user;
        }
        return null;
    }
}