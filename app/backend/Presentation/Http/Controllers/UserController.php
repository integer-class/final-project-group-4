<?php

namespace Presentation\Http\Controllers;

use Business\Services\UserService;
use Presentation\Http\Attributes\Route;
use Primitives\Model\User;

class UserController extends Controller
{
    public function __construct(private UserService $user_service)
    {
    }

    #[Route('/users', 'GET')]
    public function getUsers()
    {
        /* @var $users User[] */
        $users = $this->user_service->getAllUsers();
        $this->ok($users, "Users retrieved successfully");
    }
}