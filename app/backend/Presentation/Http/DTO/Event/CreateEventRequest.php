<?php

namespace Presentation\Http\DTO\Event;

use Presentation\Http\DTO\DtoRequestContract;

class CreateEventRequest implements DtoRequestContract
{
    public string $title;
    public string $description;
    public string $start_date;
    public string $end_date;
    public int $room_id;
    public int $user_id;

    public function __construct(
        array $data
    )
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->start_date = $data['start_date'];
        $this->end_date = $data['end_date'];
        $this->room_id = $data['room_id'];
        $this->user_id = $data['user_id'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->title)) {
            $errors['title'] = 'Title is required';
        }

        if (empty($this->description)) {
            $errors['description'] = 'Description is required';
        }

        if (empty($this->start_date)) {
            $errors['start_date'] = 'Start date is required';
        }

        if (empty($this->end_date)) {
            $errors['end_date'] = 'End date is required';
        }

        if (empty($this->room_id)) {
            $errors['room_id'] = 'Room is required';
        }

        if (empty($this->user_id)) {
            $errors['user_id'] = 'User is required';
        }

        return $errors;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'room_id' => $this->room_id,
            'user_id' => $this->user_id,
        ];
    }
}