<?php

namespace Presentation\Http\Controllers;

use Business\Services\RoomService;
use Business\Services\UserService;
use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

class AdminViewController extends Controller
{
    public function __construct(
        private readonly Session     $session,
        private readonly UserService $userService,
        private readonly RoomService $roomService
    )
    {
    }

    #[Route('/admin/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function dashboard(): void
    {
        $this->view('dashboard', [
            '__layout_title__' => 'Dashboard',
            'user' => $this->session->user
        ]);
    }

    #[Route('/admin/room-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function roomList(): void
    {
        $rooms = $this->roomService->getAllRooms();
        $this->view('admin.room-list', [
            '__layout_title__' => 'Room List',
            'user' => $this->session->user,
            'rooms' => $rooms
        ]);
    }

    #[Route('/admin/room', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function roomDetail(): void
    {
        $id = Http::query('id');
        $room = $this->roomService->getRoomById($id);
        $this->view('admin.room', [
            '__layout_title__' => 'Room Detail',
            'user' => $this->session->user,
            'room' => $room
        ]);
    }

    #[Route('/admin/schedule', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function schedule(): void
    {
        $this->view('admin.schedule', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user
        ]);
    }

    #[Route('/admin/user-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function userList(): void
    {
        $users = $this->userService->getAllUsers();
        $this->view('admin.user-list', [
            '__layout_title__' => 'User List',
            'user' => $this->session->user,
            'users' => $users
        ]);
    }
}