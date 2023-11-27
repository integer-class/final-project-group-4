<?php

namespace Primitives\Model;

class Role
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}