<?php

namespace Primitives\Models;

class Room
{
    public function __construct(
        public ?int    $id,
        public string $code,
        public string $name,
        public int    $floor,
        public int    $capacity,
        public string $side,
        public string $image,
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
            capacity: $room['Capacity'],
            side: $room['Side'],
            image: $room['Image'],
        );
    }
}