<?php

namespace Presentation\Http\DTO;

class LoginRequest
{
    public string $username;
    public string $password;

    public function __construct(array $raw)
    {
        $this->username = $raw['username'];
        $this->password = $raw['password'];
    }
}