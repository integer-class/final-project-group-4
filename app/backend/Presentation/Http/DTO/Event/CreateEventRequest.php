<?php

namespace Presentation\Http\DTO\Event;

class CreateEventRequest
{
    public function __construct(
        public string $name,
        public string $description,
        public string $start_date,
        public string $end_date,
        public int    $room_id,
        public int    $user_id,
    )
    {
    }
}