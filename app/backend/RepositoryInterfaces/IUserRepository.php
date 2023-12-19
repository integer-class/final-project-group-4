<?php

namespace RepositoryInterfaces;

use Primitives\Models\RoleName;
use Primitives\Models\User;

interface IUserRepository
{
    public function getAll(): array;
    public function getById(int $id): User;
    public function getByUsernameOrEmailOrRegistrationNumber(string $username): User | null;
    public function getAllByRole(RoleName $role): array;
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete(int $id): User;
    public function getCount(): int;
}