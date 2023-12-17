<?php

namespace Presentation\Http\Controllers;

use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

class AppController extends Controller
{
    public function __construct(private readonly Session $session)
    {
    }

    #[Route('/', 'GET')]
    #[WithSession]
    public function index(): void
    {
        $role = $this->session->getRole();
        switch ($role) {
            case RoleName::Administrator:
                Http::redirect('/admin/dashboard');
                break;
            case RoleName::Approver:
                Http::redirect('/approver/dashboard');
                break;
            case RoleName::Student:
                Http::redirect('/student/dashboard');
                break;
            default:
                Http::redirect('/login');
                break;
        }
    }

    #[Route('/login', 'GET')]
    public function login()
    {
        $this->view('login', [
            '__layout_title__' => 'Login'
        ]);
    }
}