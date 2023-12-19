<?php

namespace Primitives\Models;

class User
{
    public function __construct(
        public ?int          $id,
        public ?string       $registrationNumber,
        public string        $fullname,
        public string        $username,
        public ?string       $password,
        public string        $email,
        public string        $phone,
        public string        $avatar,
        public RoleName      $role,
        public ?StudyProgram $studyProgram
    )
    {
    }

    public function comparePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function fromArray(array $user): User
    {
        return new User(
            id: $user['Id'],
            registrationNumber: $user['RegistrationNumber'],
            fullname: $user['FullName'],
            username: $user['Username'],
            password: $user['Password'] ?? null,
            email: $user['Email'],
            phone: $user['Phone'],
            avatar: $user['Avatar'],
            role: RoleName::from($user['Role']),
            studyProgram: isset($user['StudyProgram']) ? new StudyProgram($user['StudyProgram']) : null,
        );
    }

    public function updateWith(array $user): void
    {
        if (isset($user['registrationNumber']) && $user['registrationNumber'] !== '') {
            $this->registrationNumber = $user['registrationNumber'];
        }

        if (isset($user['fullname']) && $user['fullname'] !== '') {
            $this->fullname = $user['fullname'];
        }

        if (isset($user['username']) && $user['username'] !== '') {
            $this->username = $user['username'];
        }

        if (isset($user['password']) && $user['password'] !== '') {
            $this->password = $user['password'];
        }

        if (isset($user['email']) && $user['email'] !== '') {
            $this->email = $user['email'];
        }

        if (isset($user['phone']) && $user['phone'] !== '') {
            $this->phone = $user['phone'];
        }

        if (isset($user['avatar']) && $user['avatar'] !== '') {
            $this->avatar = $user['avatar'];
        }

        if (isset($user['role']) && $user['role'] !== '') {
            $this->role = RoleName::from($user['role']);
        }

        if (isset($user['studyProgram']) && $user['studyProgram'] !== '') {
            $this->studyProgram = new StudyProgram($user['studyProgram']);
        }
    }
}