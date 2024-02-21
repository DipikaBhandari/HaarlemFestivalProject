<?php

namespace App\service;
use App\Repositories\userRepository;
use App\Model\User;

class userService
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = new userRepository();
    }
    public function getUserByEmail($email) {
        return $this->userRepository->findByEmail($email);
    }
    public function updateUser(User $user)
    {
        return $this->userRepository->updateUser($user);
    }
}