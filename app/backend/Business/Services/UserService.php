<?php

namespace Business\Services;

use Primitives\Models\Role;
use Primitives\Models\RoleName;
use Primitives\Models\StudyProgram;
use Primitives\Models\User;
use RepositoryInterfaces\IUserRepository;

class UserService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }

    public function getUserById(int $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function getUserByUsernameOrEmail(string $username_or_email): User|null
    {
        return $this->userRepository->getByUsernameOrEmail($username_or_email);
    }

    public function createUser(array $raw_user): User
    {
        $hashed_password = password_hash($raw_user['password'], PASSWORD_DEFAULT);
        $user = new User(
            id: null,
            registrationNumber: $raw_user['registration_number'],
            fullname: $raw_user['fullname'],
            username: $raw_user['username'],
            password: $hashed_password,
            email: $raw_user['email'],
            phone: $raw_user['phone'],
            avatar: $raw_user['avatar'],
            role: new Role($raw_user['role']),
            studyProgram: new StudyProgram(null, $raw_user['study_program'] ?? '')
        );
        return $this->userRepository->create($user);
    }

    public function updateUser(string $id, array $raw_user): User
    {
        $hashed_password = null;
        if (isset($raw_user['password'])) {
            $hashed_password = password_hash($raw_user['password'], PASSWORD_DEFAULT);
        }
        $user = new User(
            id: $id,
            registrationNumber: $raw_user['registration_number'],
            fullname: $raw_user['fullname'],
            username: $raw_user['username'],
            password: $hashed_password,
            email: $raw_user['email'],
            phone: $raw_user['phone'],
            avatar: $raw_user['avatar'],
            role: new Role($raw_user['role']),
            studyProgram: new StudyProgram(null, $raw_user['study_program'] ?? ''),
        );
        return $this->userRepository->update($id, $user);
    }

    public function deleteUser(int $id): void
    {
        $this->userRepository->delete($id);
    }
}