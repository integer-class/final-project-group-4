<?php

namespace RepositoryInterfaces;

use Primitives\Models\User;

interface IUserRepository
{
    public function getAllUsers(): array;
    public function getUserById(int $id): User;
    public function getUserByUsernameOrEmail(string $username_or_email): User | null;
}