<?php

namespace Presentation\Http\Controllers;

use Business\Services\AuthService;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\DTO\Auth\LoginRequest;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Exceptions\InvalidPasswordException;
use Primitives\Exceptions\UserNotFoundException;
use Primitives\Models\RoleName;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $auth_service,
                                private readonly Session     $session)
    {
    }

    #[Route('/login', 'POST')]
    public function login(LoginRequest $login_request): void
    {
        try {
            $user = $this->auth_service->login($login_request->username, $login_request->password);
            $this->session->startSession();
            $this->session->user = [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
                'role' => $user->role->name
            ];
            switch ($user->role->name) {
                case RoleName::Administrator:
                    Http::redirect('/admin/dashboard');
                    break;
                case RoleName::Lecturer:
                    Http::redirect('/lecturer/dashboard');
                    break;
                case RoleName::Student:
                    Http::redirect('/dashboard');
                    break;
            }
        } catch (InvalidPasswordException $e) {
            error_log($e->getMessage());
            Http::badRequest(['password' => 'Invalid password']);
        } catch (UserNotFoundException $e) {
            error_log($e->getMessage());
            Http::badRequest(['username' => 'User not found']);
        }
    }

    #[Route('/logout', 'POST')]
    #[WithSession]
    public function logout(): void
    {
        $this->session->destroy();
        Http::redirect('/login');
    }
}