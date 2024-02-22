<?php

namespace App\model;

class User
{
    public string $username;
    public string $email;
    public string $password;

    public string $address;

    public string $picture;
    private Roles $role;

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
     * @return Roles
     */
    public function getRole(): Roles
    {
        return $this->role;
    }

    /**
     * @param Roles $role
     */
    public function setRole(Roles $role): void
    {
        $this->role = $role;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setEmail(string $email): void
    {
        $this->email=$email;
    }
    public function setAddress(string $address): void
    {
        $this->address=$address;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password=$password;
    }

    public function jsonSerialize():mixed
    {
        return get_object_vars($this);
    }

}