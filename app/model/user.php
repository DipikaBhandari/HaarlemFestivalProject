<?php

namespace App\model;

class user
{
    private string $email;
    private $address;
    private string $password;
    private string $username;
    private $phoneNumber;
    private $profilePicture;
    private $registeredAt;
    private $id;

    /**
     * @return mixed
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * @param mixed $registeredAt
     */
    public function setRegisteredAt($registeredAt): void
    {
        $this->registeredAt = $registeredAt;
    }
    public function __construct()
    {
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setName($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */

    public string $picture;
    private string $role;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username=$username;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture=$picture;
    }
    /**
     * @return mixed
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
    public function getEmail(): string

    {
        return $this->email;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */

    public function getAddress(): string

    {
        return $this->address;
    }


    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param mixed $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password=$password;
    }
    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function jsonSerialize():mixed
    {
        return get_object_vars($this);
    }


    /**
     * @return mixed
     */


}
