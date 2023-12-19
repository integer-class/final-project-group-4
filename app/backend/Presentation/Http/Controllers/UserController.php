<?php

namespace Presentation\Http\Controllers;

use Business\Services\UserService;
use Couchbase\Role;
use Exception;
use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\DTO\User\CreateUserRequest;
use Presentation\Http\DTO\User\UpdateUserRequest;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Storage;
use Primitives\Models\RoleName;
use Primitives\Models\User;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/users', 'POST')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function createUser(CreateUserRequest $user)
    {
        try {
            $user = $this->userService->createUser($user->toArray());
            $_SESSION['success_message'] = "User with an email of {$user->email} has been created successfully";
            Http::redirect('/admin/user-list');
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['old'] = $_POST;
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect('/admin/add-user');
        }
    }

    #[Route('/users', 'PUT')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function updateUser(UpdateUserRequest $user)
    {
        try {
            $user = $this->userService->updateUser($user->toArray());
            $_SESSION['success_message'] = "User with an email of {$user->email} has been updated successfully";
            Http::redirect('/admin/user-list');
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['old'] = $_POST;
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect('/admin/edit-user?id=' . $user->id);
        }
    }

    #[Route('/users', 'DELETE')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function deleteUser()
    {
        try {
            $id = Http::query('id');
            $user = $this->userService->deleteUser($id);
            $_SESSION['success_message'] = "User with the name of {$user->fullname} has been deleted successfully";
            Http::redirect('/admin/user-list');
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect('/admin/user-list');
        }
    }
}