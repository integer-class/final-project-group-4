<?php

namespace Primitives\Model;

class User
{
    public int $id;
    public string $fullname;
    public string $username;
    public string $email;
    public string $phone;
    public string $avatar;
    public Role $role;

    public function __construct(int    $id,
                                string $fullname,
                                string $username,
                                string $email,
                                string $phone,
                                string $avatar,
                                Role   $role)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar = $avatar;
        $this->role = $role;
    }
}