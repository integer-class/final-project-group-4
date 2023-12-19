<?php

namespace Presentation\Http\Controllers;

use Business\Services\EventService;
use Business\Services\RoomService;
use Business\Services\UserService;
use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\ApprovalStatus;
use Primitives\Models\RoleName;

class ApproverViewController extends Controller
{
    public function __construct(
        private readonly Session      $session,
        private readonly RoomService  $roomService,
        private readonly EventService $eventService,
        private readonly UserService  $userService
    )
    {
    }

    #[Route('/approver/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function dashboard(): void
    {
        $roomsCount = $this->roomService->getRoomsCount();
        $pendingEventsCount = $this->eventService->getPendingEventsCount();
        $approvedEventsCount = $this->eventService->getApprovedEventsCount();
        $rejectedEventsCount = $this->eventService->getRejectedEventsCount();
        $this->view('dashboard', [
            '__layout_title__' => 'Dashboard',
            'user' => $this->session->user,
            'roomsCount' => $roomsCount,
            'pendingEventsCount' => $pendingEventsCount,
            'approvedEventsCount' => $approvedEventsCount,
            'rejectedEventsCount' => $rejectedEventsCount
        ]);
    }

    #[Route('/approver/room-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function roomList(): void
    {
        $rooms = $this->roomService->getAllRooms();
        $this->view('room-list', [
            '__layout_title__' => 'Room List',
            'user' => $this->session->user,
            'rooms' => $rooms
        ]);
    }

    #[Route('/approver/room', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function roomDetail(): void
    {
        $id = Http::query('id');
        $room = $this->roomService->getRoomById($id);
        $events = $this->eventService->getEventsByRoomId($id);
        $this->view('approver.room', [
            '__layout_title__' => 'Room Detail',
            'user' => $this->session->user,
            'room' => $room,
            'events' => $events
        ]);
    }

    #[Route('/approver/schedule', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function schedule(): void
    {
        $events = $this->eventService->getAllEventsNeedingApprovalFromCurrentUser();
        $this->view('schedule', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'events' => $events
        ]);
    }

    #[Route('/approver/event', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function eventDetail(): void
    {
        $id = Http::query('id');
        $event = $this->eventService->getEventById($id);
        $approvers = $this->userService->getAllApprovers();
        $previousApproverStatus = $this->eventService->getPreviousApproverStatus($event->id, $this->session->user->id);
        // the approval needs to be done in order, hence why we need to check these things
        $isAllowedToApprove =
            // more than zero approvers have been assigned
            count($event->approvers) <= 0 ||
            // the user is an approver and the event is pending for their approval
            array_filter($event->approvers, fn($approver) => $approver->user->id === $this->session->user->id && $approver->status === ApprovalStatus::Pending) &&
            // the user is an approver and the event is pending for the previous approver
            $previousApproverStatus === ApprovalStatus::Approved;

        $this->view('event-detail', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'event' => $event,
            'approvers' => $approvers,
            'isAllowedToApprove' => $isAllowedToApprove
        ]);
    }
}