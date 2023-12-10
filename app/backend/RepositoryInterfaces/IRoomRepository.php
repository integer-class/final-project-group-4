<?php

namespace RepositoryInterfaces;

use Primitives\Models\Room;

interface IRoomRepository
{
    public function getAll(): array;
    public function getById(int $id): Room;
    public function getByCode(string $code): Room;
    public function create(Room $room): Room;
    public function update(int $id, Room $room): Room;
    public function delete(int $id): void;
}