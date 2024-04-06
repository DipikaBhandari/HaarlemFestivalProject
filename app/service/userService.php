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

    public function captchaVerification(&$systemMessage)
    {
        $secret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
        $data = file_get_contents($url);
        $row = json_decode($data);
        if ($row->success == "true") {
            return true;
        } else {
            $systemMessage = "you are a robot";
            return false;
        }
    }

}

