<?php

namespace Repository;

use Primitives\Models\Role;
use Primitives\Models\User;
use RepositoryInterfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    public function __construct(private readonly MssqlClient $databaseClient)
    {
    }

    public function getAllUsers(): array
    {
        $users = $this->databaseClient->executeQuery("
            SELECT
                [User].Id,
                Username,
                FullName,
                Email,
                Phone,
                Avatar,
                R.Name as Role
            FROM
                 dbo.User
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
        ");

        return array_map(function ($user) {
            return new User(
                $user['Id'],
                $user['FullName'],
                $user['Username'],
                $user['Password'],
                $user['Email'],
                $user['Phone'],
                $user['Avatar'],
                new Role($user['Role'])
            );
        }, $users);
    }

    public function getUserById(int $id): User
    {
        $row = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
                Username,
                Password,
                FullName,
                Email,
                Phone,
                Avatar,
                R.Name as Role
            FROM
                 dbo.User
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
            WHERE [User].Id = ?
        ", [$id])[0];

        return new User(
            $row['Id'],
            $row['FullName'],
            $row['Username'],
            $row['Password'],
            $row['Email'],
            $row['Phone'],
            $row['Avatar'],
            new Role($row['Role'])
        );
    }

    public function getUserByUsernameOrEmail(string $username_or_email): User | null
    {
        $rows = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
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
        if (sizeof($rows) < 1) return null;

        $row = $rows[0];
        return new User(
            $row['Id'],
            $row['FullName'],
            $row['Username'],
            $row['Password'],
            $row['Email'],
            $row['Phone'],
            $row['Avatar'],
            new Role($row['Role'])
        );
    }
}