<?php

namespace Business\Services;

use Presentation\Http\Helpers\Session;
use Primitives\Models\Event;
use Primitives\Models\RoleName;
use Repository\EventRepository;

class EventService
{
    public function __construct(
        private readonly Session         $session,
        private readonly EventRepository $eventRepository,
    )
    {
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

    public function getPendingEventsCount(): int
    {
        $role = $this->session->user->role;
        if ($role != RoleName::Administrator) {
            return $this->eventRepository->getPendingEventsCount($this->session->user->id, $this->session->user->role);
        }
        return $this->eventRepository->getPendingEventsCount();
    }

    public function getApprovedEventsCount(): int
    {
        $role = $this->session->user->role;
        if ($role != RoleName::Administrator) {
            return $this->eventRepository->getApprovedEventsCount($this->session->user->id, $this->session->user->role);
        }
        return $this->eventRepository->getApprovedEventsCount();
    }

    public function getRejectedEventsCount(): int
    {
        $role = $this->session->user->role;
        if ($role != RoleName::Administrator) {
            return $this->eventRepository->getRejectedEventsCount($this->session->user->id, $this->session->user->role);
        }
        return $this->eventRepository->getRejectedEventsCount();
    }

    public function getAllEventsNeedingApprovalFromCurrentUser(): array
    {
        return $this->eventRepository->getAllEventsNeedingApprovalFrom($this->session->user->id);
    }

    public function getAllEventsFromCurrentUser(): array
    {
        return $this->eventRepository->getAllEventsFrom($this->session->user->id);
    }
}