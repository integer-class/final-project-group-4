<?php

namespace Repository;

use Primitives\Models\Role;
use Primitives\Models\RoleName;
use Primitives\Models\StudyProgram;
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
                R.Name as Role,
                SP.Name as StudyProgram
            FROM
                 dbo.[User]
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
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
                R.Name as Role,
                SP.Name as StudyProgram
            FROM
                 dbo.User
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
            LEFT JOIN dbo.User_StudyPrograms USP on [User].ID = USP.UserID
            LEFT JOIN dbo.StudyPrograms SP on USP.StudyProgramID = SP.ID
            WHERE [User].Id = ?
        ", [$id])[0];

        return User::fromArray($user);
    }

    public function getByUsernameOrEmail(string $username_or_email): User|null
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
                R.Name as Role
            FROM
                 dbo.[User]
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
            WHERE Username = ? OR Email = ?
        ", [$username_or_email, $username_or_email]);
        if (sizeof($users) < 1) return null;

        return User::fromArray($users[0]);
    }

    public function create(User $user): User
    {
        $user_id = $this->databaseClient->executeQuery("
            INSERT INTO dbo.[User] (RegistrationNumber, FullName, Username, Password, Email, Phone, Avatar)
            VALUES (?, ?, ?, ?, ?, ?, ?);

            SELECT SCOPE_IDENTITY() as Id;
        ", [
            $user->registrationNumber,
            $user->fullname,
            $user->username,
            $user->password,
            $user->email,
            $user->phone,
            $user->avatar
        ])[0]['Id'];

        $role_id = $this->databaseClient->executeQuery("
            SELECT ID FROM dbo.Role WHERE Name = ?
        ", [$user->role->name])[0]['Id'];

        $this->databaseClient->executeNonQuery("
            INSERT INTO dbo.User_Role (UserID, RoleID)
            VALUES (?, ?)
        ", [$user_id, $role_id]);

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
                Avatar = ?
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

        // update user role
        $role_id = $this->databaseClient->executeQuery("
            SELECT ID FROM dbo.Role WHERE Name = ?
        ", [$user->role->name])[0]['Id'];

        $this->databaseClient->executeNonQuery("
            UPDATE dbo.User_Role
            SET RoleID = ?
            WHERE UserID = ?
        ", [$role_id, $id]);

        return $user;
    }

    public function delete(int $id): void
    {
        $this->databaseClient->executeNonQuery("
            DELETE FROM dbo.[User] WHERE Id = ?
        ", [$id]);
    }
}