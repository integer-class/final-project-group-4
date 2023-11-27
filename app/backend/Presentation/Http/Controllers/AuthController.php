<?php

namespace Presentation\Http\Controllers;

use Business\Services\AuthService;
use Presentation\Http\Attributes\Route;
use Presentation\Http\DTO\LoginRequest;
use Primitives\Exceptions\InvalidPasswordException;
use Primitives\Exceptions\UserNotFoundException;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $auth_service)
    {
    }


    #[Route('/login', 'POST')]
    public function login(LoginRequest $login_request)
    {
        try {
            $user_id = $this->auth_service->login($login_request->username, $login_request->password);
            $this->ok([
                "user_id" => $user_id
            ], "Login successful");
        } catch (InvalidPasswordException $e) {
            $this->badRequest("Invalid password");
        } catch (UserNotFoundException $e) {
            $this->badRequest("User not found");
        }
    }

    public function logout()
    {
        $this->ok(null, "Logout successful");
    }
}