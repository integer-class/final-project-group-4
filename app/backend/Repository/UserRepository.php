<?php

namespace Repository;

use Primitives\Model\Role;
use Primitives\Model\User;
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
                Id,
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
                $user['Email'],
                $user['Phone'],
                $user['Avatar'],
                new Role($user['Role'])
            );
        }, $users);
    }

    public function getUserById(int $id): User
    {
        // TODO: Implement getUserById() method.
    }

    public function getUserByUsernameOrEmail(string $usernameOrEmail): User
    {
        // TODO: Implement getUserByUsernameOrEmail() method.
    }
}