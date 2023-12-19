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
        private readonly UserService  $userService,
    )
    {
    }

    #[Route('/student/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
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

    #[Route('/student/room-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function roomList(): void
    {
        $rooms = $this->roomService->getAllRooms();
        $this->view('room-list', [
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

    #[Route('/student/room/reserve', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function roomReservation(): void
    {
        $id = Http::query('id');
        $room = $this->roomService->getRoomById($id);
        $this->view('student.room-reservation', [
            '__layout_title__' => 'Room Reservation',
            'user' => $this->session->user,
            'room' => $room,
        ]);
    }

    #[Route('/student/schedule', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function schedule(): void
    {
        $events = $this->eventService->getAllEventsFromCurrentUser();
        $this->view('schedule', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'events' => $events
        ]);
    }

    #[Route('/student/event', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function eventDetail(): void
    {
        $id = Http::query('id');
        $event = $this->eventService->getEventById($id);
        $approvers = $this->userService->getAllApprovers();
        $this->view('event-detail', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'event' => $event,
            'approvers' => $approvers
        ]);
    }
}