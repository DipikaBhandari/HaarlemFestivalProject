<?php

namespace App\service;

use App\Repositories\userRepository;
use Exception;
use PDO;

class userService
{
    private userRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new userRepository();
    }

    public function authenticateUser($username, $password)
    {
        $user = $this->userRepository->verifyUser($username, $password);
        if ($user) {

            return $user;
        }
        return null;
    }

    public function registered($newUser): bool
    {
        $plainPassword = $newUser['password'];
        $newUser['password'] = $this->hashPassword($plainPassword);
        $image = $newUser['picture'];
        if (!empty($image['name'])) {
            $newUser['picture'] = $this->userImage($image);
        } else {
            $newUser['picture'] = DEFAULT_PROFILE; // default image
        }
     return  $this->userRepository->registerUser($newUser);

    }
    public function userImage($image)
    {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        $upload_dir = __DIR__ . '/../public/img/';
        if (!move_uploaded_file($image['tmp_name'], $upload_dir . $imageName)) {
            throw new Exception("Failed to move uploaded file.");
        }
        return $imageName;
    }
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}