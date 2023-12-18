<?php

namespace Business\Services;

use Presentation\Http\Helpers\Session;
use Primitives\Models\Event;
use Repository\EventRepository;

class EventService
{
    public function __construct(
        private readonly EventRepository $eventRepository,
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

    public function assignApprover(int $id, array $approvers): Event
    {
        return $this->eventRepository->assignApprover($id, $approvers);
    }

    public function approve(int $id, int $approverId): Event
    {
        return $this->eventRepository->approve($id, $approverId);
    }

    public function reject(int $id, int $approverId, string $reason): Event
    {
        return $this->eventRepository->reject($id, $approverId, $reason);
    }

    public function deleteEvent(int $id): array
    {
        $this->eventRepository->delete($id);
    }

    public function getPendingEventsCount(): int
    {
        return $this->eventRepository->getPendingEventsCount();
    }

    public function getApprovedEventsCount(): int
    {
        return $this->eventRepository->getApprovedEventsCount();
    }

    public function getRejectedEventsCount(): int
    {
        return $this->eventRepository->getRejectedEventsCount();
    }

    public function getAllEventsNeedingApprovalFromCurrentUser(): array
    {
        $session = Session::getInstance();
        return $this->eventRepository->getAllEventsNeedingApprovalFrom($session->user['id']);
    }
}