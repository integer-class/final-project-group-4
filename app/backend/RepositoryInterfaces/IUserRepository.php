<?php

namespace RepositoryInterfaces;

use Primitives\Model\User;

interface IUserRepository
{
    public function getAllUsers(): array;
    public function getUserById(int $id): User;
    public function getUserByUsernameOrEmail(string $usernameOrEmail): User;
}