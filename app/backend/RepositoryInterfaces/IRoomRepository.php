<?php

namespace RepositoryInterfaces;

use Primitives\Models\Room;

interface IRoomRepository
{
    public function getAll(): array;
    public function getById(int $id): Room;
    public function search(string $query): array;
    public function create(Room $room): Room;
    public function update(Room $room): Room;
    public function delete(int $id): void;
    public function getCount(): int;
}