<?php

namespace Business\Services;

use Primitives\Exceptions\InvalidPasswordException;
use Primitives\Exceptions\UserNotFoundException;
use Primitives\Models\User;
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
    public function login(string $usernameOrEmail, string $password): User
    {
        $user = $this->userRepository->getByUsernameOrEmailOrRegistrationNumber($usernameOrEmail);
        if ($user === null) {
            throw new UserNotFoundException();
        }

        if (!$user->comparePassword($password)) {
            throw new InvalidPasswordException();
        }

        return $user;
    }
}