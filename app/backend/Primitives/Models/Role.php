<?php

namespace Primitives\Models;

class Role
{
    public RoleName $name;

    public function __construct(string $name)
    {
        $this->name = RoleName::from($name);
    }
}