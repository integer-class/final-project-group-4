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
use Primitives\Models\User;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService,
                                private readonly Session     $session)
    {
    }

    #[Route('/login', 'POST')]
    public function login(LoginRequest $login_request): void
    {
        try {
            $user = $this->authService->login($login_request->username, $login_request->password);
            $this->session->startSession();
            $this->session->user = new User(
                id: $user->getId(),
                registrationNumber: $user->getRegistrationNumber(),
                fullname: $user->getFullname(),
                username: $user->getUsername(),
                password: null,
                email: $user->getEmail(),
                phone: $user->getPhone(),
                avatar: $user->getAvatar(),
                role: $user->getRole(),
            );
            switch ($user->getRole()) {
                case RoleName::Administrator:
                    Http::redirect('/admin/dashboard');
                    break;
                case RoleName::Approver:
                    Http::redirect('/approver/dashboard');
                    break;
                case RoleName::Student:
                    Http::redirect('/student/dashboard');
                    break;
            }
        } catch (InvalidPasswordException $e) {
            error_log($e->getMessage());
            $_SESSION['error_message'] = 'Invalid password';
            Http::redirect($_SERVER['HTTP_REFERER']);
        } catch (UserNotFoundException $e) {
            error_log($e->getMessage());
            $_SESSION['error_message'] = 'User was not found';
            Http::redirect($_SERVER['HTTP_REFERER']);
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