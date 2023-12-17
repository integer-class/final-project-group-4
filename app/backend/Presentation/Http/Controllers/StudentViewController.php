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

class StudentViewController extends Controller
{
    public function __construct(
        private readonly Session      $session,
        private readonly RoomService  $roomService,
        private readonly EventService $eventService,
    )
    {
    }

    #[Route('/student/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function dashboard(): void
    {
        $this->view('dashboard', [
            '__layout_title__' => 'Dashboard',
            'user' => $this->session->user
        ]);
    }

    #[Route('/student/room-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function roomList(): void
    {
        $rooms = $this->roomService->getAllRooms();
        $this->view('admin.room-list', [
            '__layout_title__' => 'Room List',
            'user' => $this->session->user,
            'rooms' => $rooms
        ]);
    }

    #[Route('/student/room', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function roomDetail(): void
    {
        $id = Http::query('id');
        $room = $this->roomService->getRoomById($id);
        $events = $this->eventService->getEventsByRoomId($id);
        $this->view('student.room', [
            '__layout_title__' => 'Room Detail',
            'user' => $this->session->user,
            'room' => $room,
            'events' => $events
        ]);
    }

    #[Route('/student/schedule', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function schedule(): void
    {
        $this->view('admin.schedule', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user
        ]);
    }
}