<?php

namespace Primitives\Models;

class User
{
    public function __construct(
        public ?int    $id,
        public ?string $registration_number,
        public string  $fullname,
        public string  $username,
        public string  $password,
        public string  $email,
        public string  $phone,
        public string  $avatar,
        public Role    $role,
    )
    {
    }

    public function comparePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}