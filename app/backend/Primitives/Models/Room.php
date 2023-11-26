<?php

namespace Primitives\Model;

class Room
{
    public int $id;
    public string $code;
    public string $name;
    public int $floor;
    public int $floor_plan_index;
    public int $capacity;
    public string $side;
}