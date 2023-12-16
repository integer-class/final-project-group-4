<?php

namespace Presentation\Http\Controllers;

use Business\Services\UserService;
use Presentation\Http\Attributes\Route;
use Presentation\Http\DTO\User\CreateUserRequest;
use Presentation\Http\DTO\User\UpdateUserRequest;
use Presentation\Http\Helpers\Http;
use Primitives\Models\User;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/users', 'GET')]
    public function getUsers()
    {
        $users = $this->userService->getAllUsers();
        Http::ok($users, "Users retrieved successfully");
    }

    #[Route('/users', 'GET')]
    public function getUserById()
    {
        $id = Http::query('id');
        $user = $this->userService->getUserById($id);
        Http::ok($user, "User retrieved successfully");
    }

    #[Route('/users', 'POST')]
    public function createUser(CreateUserRequest $user)
    {
        $avatar = null;
        try {
            $avatar = Http::handleUploadedImage('avatar');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            Http::badRequest(['avatar' => $e->getMessage()]);
            return;
        }

        $user = $this->userService->createUser(array_merge($user->toArray(), [
            'avatar' => $avatar,
        ]));
        Http::ok($user, "User created successfully");
    }

    #[Route('/users', 'PUT')]
    public function updateUser(UpdateUserRequest $user)
    {
        $id = Http::query('id');

        // update avatar if it's provided
        $avatar = null;
        if ($_FILES['avatar'] && $_FILES['avatar']['size'] > 0) {
            try {
                $avatar = Http::updateUploadedImage('avatar', $user->avatar);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                Http::badRequest(['avatar' => $e->getMessage()]);
                return;
            }
        }

        $user = $this->userService->updateUser($id, array_merge($user->toArray(), [
            'avatar' => $avatar,
        ]));
        Http::ok($user, "User updated successfully");
    }

    #[Route('/users', 'DELETE')]
    public function deleteUser()
    {
        $id = Http::query('id');
        $this->userService->deleteUser($id);
        Http::ok(null, "User deleted successfully");
    }
}