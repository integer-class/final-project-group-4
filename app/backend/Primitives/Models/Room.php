<?php

namespace Primitives\Models;

class Room
{
    public function __construct(
        public string $code,
        public string $name,
        public int    $floor,
        public int    $floor_plan_index,
        public int    $capacity,
        public string $side
    )
    {
    }
}