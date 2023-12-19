<?php

namespace Presentation\Http\DTO\Room;

use Presentation\Http\DTO\DtoRequestContract;

class UpdateRoomRequest implements DtoRequestContract
{
    public string $name;
    public string $code;
    public int $floor;
    public int $capacity;
    public string $side;

    public function __construct(array $raw)
    {
        $this->name = $raw['name'];
        $this->code = $raw['code'];
        $this->floor = $raw['floor'];
        $this->capacity = $raw['capacity'];
        $this->side = $raw['side'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = 'Name is required';
        }

        if (empty($this->code)) {
            $errors['code'] = 'Code is required';
        }

        if (empty($this->floor)) {
            $errors['floor'] = 'Floor is required';
        }

        if (empty($this->capacity)) {
            $errors['capacity'] = 'Capacity is required';
        }

        if (empty($this->side)) {
            $errors['side'] = 'Side is required';
        }

        return $errors;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'floor' => $this->floor,
            'capacity' => $this->capacity,
            'side' => $this->side,
        ];
    }
}