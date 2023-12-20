<?php

namespace Business\Services;

use Exception;
use Presentation\Http\Helpers\Session;
use Primitives\Models\ApprovalStatus;
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

    /**
     * @throws Exception
     */
    public function createEvent(array $event): Event
    {
        $isValid = $this->eventRepository->isRoomAvailableFromDateRange($event['room_id'], $event['start_date'], $event['end_date']);
        if (!$isValid) {
            throw new Exception("The room is not available for the selected date range.");
        }
        return $this->eventRepository->create($event);
    }

    public function assignApprover(int $id, array $approvers): Event
    {
        return $this->eventRepository->assignApprover($id, $approvers);
    }

    public function getPreviousApproverStatus(int $id, int $approverId): ApprovalStatus
    {
        return $this->eventRepository->getPreviousApproverStatus($id, $approverId);
    }

    /**
     * @throws Exception
     */
    public function approve(int $id, int $approverId): Event
    {
        if ($this->session->user->role != RoleName::Administrator) {
            throw new Exception("You are not authorized to approve events.");
        }
        if ($this->eventRepository->getPreviousApproverStatus($id, $approverId) != ApprovalStatus::Approved) {
            throw new Exception("You are not authorized to approve this event.");
        }
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