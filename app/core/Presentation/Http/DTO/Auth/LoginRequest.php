<?php

namespace Presentation\Http\DTO\Auth;

use Presentation\Http\DTO\DtoRequestContract;

class LoginRequest implements DtoRequestContract
{
    public string $username;
    public string $password;

    public function __construct(array $raw)
    {
        $this->username = $raw['username'];
        $this->password = $raw['password'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->username)) {
            $errors['username'] = 'Username is required';
        }

        if (empty($this->password)) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}