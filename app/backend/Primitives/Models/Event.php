<?php

namespace Primitives\Model;

class Event
{
    public int $id;
    public string $title;
    public string $description;
    public \DateTime $starts_at;
    public \DateTime $ends_at;
    public Room $room;
    public User $pic;
}