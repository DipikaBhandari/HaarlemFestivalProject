<?php

namespace App\service;
use App\Repositories\userRepository;
use App\Model\user;
use DateTime;

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
        try{
            $user = $this->userRepository->verifyUser($username, $password);
            return $user;
        } catch (\Exception $e){
            error_log("Error authenticating user: " . $e->getMessage());
            return null;
        }
    }

    public function sendResetLink($email){
        try{
            $resetToken = $this->userRepository->sendResetLink($email);
            if ($resetToken){
                $result = $this->emailService->sendPasswordResetEmail($email, $resetToken);
                return $result;
            } else{
                return false;
            }
        } catch (\Exception $e) {
            error_log('Error sending reset link: ' . $e->getMessage());
            return false;
        }
    }

    public function validateToken($token, $email)
    {
        try {
            return $this->userRepository->validateToken($token, $email);
        } catch(\Exception $e) {
            error_log('Error validating password reset token: ' . $e->getMessage());
            return false;
        }
    }

    public function updatePassword($email, $password)
    {
        try{
            return $this->userRepository->updatePassword($email, $password);
        } catch(\Exception $e) {
            error_log('Error updating password: ' . $e->getMessage());
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }
    public function updateUser(user $user)
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

    public function fetchAllUsers()
    {
        try {
            return $this->userRepository->fetchAllUsers();
        } catch (Exception $e) {
            error_log("Error fetching all users: " . $e->getMessage());
            return [];
        }
    }
    public function createUser(user $user): bool
    {
        try {
            $currentDateTime = new DateTime();
            $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');
            return $this->userRepository->createUser(
                $user->getUsername(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getAddress(),
                $user->getPhoneNumber(),
                $user->getRole(),
                $formattedDateTime
            );
        } catch (Exception $e) {
            error_log("Error during registration: " . $e->getMessage());
            return false;
        }
    }
    public function deleteUser($identifier)
    {
        return $this->userRepository->deleteUser($identifier);
    }
    public function getUserDetailsForEditing($identifier) {
        return $this->userRepository->getUserByUserName($identifier);
    }

    public function submitUserEdit(user $editedUser) {
        return $this->userRepository->updateUsers($editedUser);
    }
}

