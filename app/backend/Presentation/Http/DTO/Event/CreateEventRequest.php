<?php

namespace Presentation\Http\DTO\Event;

class CreateEventRequest
{
        public string $title;
        public string $description;
        public string $start_date;
        public string $end_date;
        public int    $room_id;
        public int    $user_id;
    public function __construct(
        array $data
    )
    {
        $this->title        = $data['title'];
        $this->description = $data['description'];
        $this->start_date  = $data['start_date'];
        $this->end_date    = $data['end_date'];
        $this->room_id     = $data['room_id'];
        $this->user_id     = $data['user_id'];
    }
}