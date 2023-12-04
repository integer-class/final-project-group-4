<?php

namespace Presentation\Http\Controllers;

use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

class AdminController extends Controller
{
    public function __construct(private readonly Session $session)
    {
    }

    #[Route('/admin/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function dashboard(): void
    {
        $this->view('admin.dashboard', [
            '__layout_title__' => 'Dashboard',
            'user' => $this->session->user
        ]);
    }

    #[Route('/admin/room-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function roomList(): void
    {
        $this->view('admin.room-list', [
            '__layout_title__' => 'Room List',
            'user' => $this->session->user
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
        $this->view('admin.user-list', [
            '__layout_title__' => 'User List',
            'user' => $this->session->user
        ]);
    }
}