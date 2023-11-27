<?php

use RepositoryInterfaces\IUserRepository;

class UserService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    public function getUsers(): array
    {
        return $this->userRepository->getAllUsers();
    }
}