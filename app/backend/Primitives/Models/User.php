<?php

namespace Primitives\Models;

class User
{
    public function __construct(
        public ?int         $id,
        public ?string      $registrationNumber,
        public string       $fullname,
        public string       $username,
        public ?string      $password,
        public string       $email,
        public string       $phone,
        public string       $avatar,
        public Role         $role,
        public StudyProgram $studyProgram
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
            role: new Role($user['Role']),
            studyProgram: new StudyProgram($user['StudyProgram'] ?? '-')
        );
    }
}