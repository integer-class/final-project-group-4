<?php

namespace Presentation\Http\DTO\Room;

use Presentation\Http\DTO\DtoRequestContract;

class UpdateRoomRequest implements DtoRequestContract
{
    public string $name;
    public string $code;
    public int $floor;
    public int $floor_plan_index;
    public int $capacity;
    public string $side;

    public function __construct(array $raw)
    {
        $this->name = $raw['name'];
        $this->code = $raw['code'];
        $this->floor = $raw['floor'];
        $this->floor_plan_index = $raw['floor_plan_index'];
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

        if (empty($this->floor_plan_index)) {
            $errors['floor_plan_index'] = 'Floor plan index is required';
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
            'floor_plan_index' => $this->floor_plan_index,
            'capacity' => $this->capacity,
            'side' => $this->side,
        ];
    }
}