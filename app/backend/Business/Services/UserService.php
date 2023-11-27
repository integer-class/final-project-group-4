<?php

namespace Business\Services;

use RepositoryInterfaces\IUserRepository;

class UserService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }
}