<?php

namespace Business\Services;

use Primitives\Exceptions\InvalidPasswordException;
use Primitives\Exceptions\UserNotFoundException;
use RepositoryInterfaces\IUserRepository;

class AuthService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidPasswordException
     */
    public function login(string $usernameOrEmail, string $password): string
    {
        $user = $this->userRepository->getUserByUsernameOrEmail($usernameOrEmail);
        if ($user === null) {
            throw new UserNotFoundException();
        }

        if ($user->password !== $password) {
            throw new InvalidPasswordException();
        }

        return $user->id;
    }
}