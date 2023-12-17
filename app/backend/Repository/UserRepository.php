<?php

namespace Repository;

use Primitives\Models\RoleName;
use Primitives\Models\User;
use RepositoryInterfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    public function __construct(private readonly MssqlClient $databaseClient)
    {
    }

    public function getAll(): array
    {
        $users = $this->databaseClient->executeQuery("
            SELECT
                [User].Id,
                RegistrationNumber,
                Username,
                FullName,
                Email,
                Phone,
                Avatar,
                Role,
                SP.Name as StudyProgram
            FROM
                 dbo.[User]
            LEFT JOIN dbo.User_StudyPrograms USP on [User].ID = USP.UserID
            LEFT JOIN dbo.StudyPrograms SP on USP.StudyProgramID = SP.ID
        ");

        return array_map(fn($user) => User::fromArray($user), $users);
    }

    public function getById(int $id): User
    {
        $user = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
                RegistrationNumber,
                Username,
                Password,
                FullName,
                Email,
                Phone,
                Avatar,
                Role
            FROM
                 dbo.[User]
            LEFT JOIN dbo.User_StudyPrograms USP on [User].ID = USP.UserID
            LEFT JOIN dbo.StudyPrograms SP on USP.StudyProgramID = SP.ID
            WHERE [User].Id = ?
        ", [$id])[0];

        return User::fromArray($user);
    }

    public function getByUsernameOrEmailOrRegistrationNumber(string $username): User|null
    {
        $users = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
                RegistrationNumber,
                Username,
                Password,
                FullName,
                Email,
                Phone,
                Avatar,
                Role
            FROM
                 dbo.[User]
            WHERE Username = ? OR Email = ? OR RegistrationNumber = ?
        ", [
            $username,
            $username,
            $username
        ]);
        if (sizeof($users) < 1) return null;

        return User::fromArray($users[0]);
    }

    public function create(User $user): User
    {
        $user_id = $this->databaseClient->executeQuery("
            INSERT INTO dbo.[User] (RegistrationNumber, FullName, Username, Password, Email, Phone, Avatar, Role)
            VALUES (:registration_number, :fullname, :username, :password, :email, :phone, :avatar, :role);

            SELECT SCOPE_IDENTITY() as Id;
        ", [
            'registration_number' => $user->registrationNumber,
            'fullname' => $user->fullname,
            'username' => $user->username,
            'password' => $user->password,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
            'role' => $user->role->name
        ])[0]['Id'];

        return $user;
    }

    public function update(User $user): User
    {
        // update user based on the available fields
        $this->databaseClient->executeNonQuery("
            UPDATE dbo.[User]
            SET
                RegistrationNumber = ?,
                FullName = ?,
                Username = ?,
                Password = ?,
                Email = ?,
                Phone = ?,
                Avatar = ?,
                Role = ?
            WHERE Id = ?
        ", [
            $user->registrationNumber,
            $user->fullname,
            $user->username,
            $user->password,
            $user->email,
            $user->phone,
            $user->avatar,
            $user->id
        ]);

        return $user;
    }

    public function delete(int $id): void
    {
        $this->databaseClient->executeNonQuery("
            DELETE FROM dbo.[User] WHERE Id = ?
        ", [$id]);
    }
}