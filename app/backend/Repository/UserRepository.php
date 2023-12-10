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
                R.Name as Role
            FROM
                 dbo.User
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
        ");

        return array_map(function ($user) {
            return new User(
                $user['Id'],
                $user['RegistrationNumber'],
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

    public function getById(int $id): User
    {
        $row = $this->databaseClient->executeQuery("
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
                 dbo.User
            LEFT JOIN dbo.User_Role UR on [User].ID = UR.UserID
            LEFT JOIN dbo.Role R on UR.RoleID = R.ID
            WHERE [User].Id = ?
        ", [$id])[0];

        return new User(
            $row['Id'],
            $row['RegistrationNumber'],
            $row['FullName'],
            $row['Username'],
            $row['Password'],
            $row['Email'],
            $row['Phone'],
            $row['Avatar'],
            new Role($row['Role'])
        );
    }

    public function getByUsernameOrEmail(string $username_or_email): User | null
    {
        $rows = $this->databaseClient->executeQuery("
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
        if (sizeof($rows) < 1) return null;

        $row = $rows[0];
        return new User(
            $row['Id'],
            $row['RegistrationNumber'],
            $row['FullName'],
            $row['Username'],
            $row['Password'],
            $row['Email'],
            $row['Phone'],
            $row['Avatar'],
            new Role($row['Role'])
        );
    }

    public function create(User $user): User
    {
        $user_id = $this->databaseClient->executeQuery("
            INSERT INTO dbo.[User] (RegistrationNumber, FullName, Username, Password, Email, Phone, Avatar)
            VALUES (?, ?, ?, ?, ?, ?, ?);

            SELECT SCOPE_IDENTITY() as Id;
        ", [
            $user->registration_number,
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

    public function update(int $id, User $user): User
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
            $user->registration_number,
            $user->fullname,
            $user->username,
            $user->password,
            $user->email,
            $user->phone,
            $user->avatar,
            $id
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