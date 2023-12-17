<?php

namespace Business\Services;

use Primitives\Models\Event;
use Repository\EventRepository;

class EventService
{
    public function __construct(
        private EventRepository $eventRepository
    ) {
    }

    public function getAllEvents(): array
    {
        return $this->eventRepository->getAll();
    }

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->getById($id);
    }

    public function getEventsByRoomId(int $roomId): array
    {
        return $this->eventRepository->getByRoomId($roomId);
    }

    public function createEvent(array $event): Event
    {
        return $this->eventRepository->create($event);
    }

    public function updateEvent(array $event): array
    {
        return $this->eventRepository->updateEvent($event);
    }

    public function deleteEvent(int $id): array
    {
        return $this->eventRepository->deleteEvent($id);
    }
}