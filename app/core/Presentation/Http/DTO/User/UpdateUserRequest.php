<?php

namespace Presentation\Http\DTO\User;

use Presentation\Http\DTO\DtoRequestContract;

class UpdateUserRequest implements DtoRequestContract
{
    // same field as the User class
    public int $id;
    public string $registration_number;
    public string $fullname;
    public string $username;
    public string $password;
    public string $confirm_password;
    public string $email;
    public string $phone;
    public string $role;

    public function __construct(array $raw)
    {
        $this->id = $raw['id'];
        $this->registration_number = $raw['registration_number'];
        $this->fullname = $raw['fullname'];
        $this->username = $raw['username'];
        $this->password = $raw['password'];
        $this->email = $raw['email'];
        $this->phone = $raw['phone'];
        $this->role = $raw['role'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->registration_number)) {
            $errors['registration_number'] = 'Registration number is required';
        }

        if (sizeof($this->registration_number) !== 10) {
            $errors['registration_number'] = 'Registration number must be 10 characters long';
        }

        if (empty($this->fullname)) {
            $errors['fullname'] = 'Fullname is required';
        }

        if (empty($this->username)) {
            $errors['username'] = 'Username is required';
        }

        if ($this->password !== $this->confirm_password) {
            $errors['confirm_password'] = 'Confirm password must match password';
        }

        if (empty($this->email)) {
            $errors['email'] = 'Email is required';
        }

        if (empty($this->phone)) {
            $errors['phone'] = 'Phone is required';
        }

        if (empty($this->role)) {
            $errors['role'] = 'Role is required';
        }

        return $errors;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'registration_number' => $this->registration_number,
            'fullname' => $this->fullname,
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role
        ];
    }
}