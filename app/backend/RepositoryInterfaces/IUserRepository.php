<?php

namespace RepositoryInterfaces;

use Primitives\Models\User;

interface IUserRepository
{
    public function getAll(): array;
    public function getById(int $id): User;
    public function getByUsernameOrEmail(string $username_or_email): User | null;
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete(int $id): void;
}