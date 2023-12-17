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
use Primitives\Models\RoleName;

class ApproverViewController extends Controller
{
    public function __construct(
        private readonly Session      $session,
        private readonly RoomService  $roomService,
        private readonly EventService $eventService,
    )
    {
    }

    #[Route('/approver/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function dashboard(): void
    {
        $this->view('dashboard', [
            '__layout_title__' => 'Dashboard',
            'user' => $this->session->user
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
        $this->view('admin.schedule', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'events' => $events
        ]);
    }
}