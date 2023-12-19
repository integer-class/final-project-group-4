<?php

namespace Primitives\Models;

class Room
{
    public function __construct(
        public ?int   $id,
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

    public function updateWith(array $room): Room
    {
        if (isset($room['code']) && $room['code'] !== '') {
            $this->code = $room['code'];
        }

        if (isset($room['name']) && $room['name'] !== '') {
            $this->name = $room['name'];
        }

        if (isset($room['floor'])) {
            $this->floor = $room['floor'];
        }

        if (isset($room['capacity'])) {
            $this->capacity = $room['capacity'];
        }

        if (isset($room['side']) && $room['side'] !== '') {
            $this->side = $room['side'];
        }

        if (isset($room['image']) && $room['image'] !== '') {
            $this->image = $room['image'];
        }

        return $this;
    }
}