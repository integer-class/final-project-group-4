<?php

namespace Primitives\Models;

class Room
{
    public function __construct(
        public ?int    $id,
        public string $code,
        public string $name,
        public int    $floor,
        public int    $floor_plan_index,
        public int    $capacity,
        public string $side
    )
    {
    }

    public static function fromArray(array $room): Room
    {
        return new Room(
            id: $room['Id'],
            code: $room['Code'],
            name: $room['Name'],
            floor: $room['Floor'],
            floor_plan_index: $room['FloorPlanIndex'],
            capacity: $room['Capacity'],
            side: $room['Side']
        );
    }
}