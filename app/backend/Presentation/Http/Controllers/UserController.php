<?php

namespace Presentation\Http\Controllers;

use Presentation\Http\Attributes\Route;
use Primitives\Model\User;
use RepositoryInterfaces\IUserRepository;

class UserController extends Controller
{
    public function __construct(private IUserRepository $userRepository)
    {
    }

    #[Route('/users', 'GET')]
    public function getUsers()
    {
        /* @var $users User[] */
        $users = $this->userRepository->getAllUsers();
        $this->ok($users, "Users retrieved successfully");
    }
}