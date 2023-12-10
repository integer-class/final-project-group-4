<?php

namespace Primitives\Models;

class Event
{
    public function __construct(
        public int       $id,
        public string    $title,
        public string    $description,
        public \DateTime $starts_at,
        public \DateTime $ends_at,
        public Room      $room,
        public User      $pic
    )
    {
    }
}