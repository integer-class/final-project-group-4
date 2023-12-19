<?php

namespace RepositoryInterfaces;

use Primitives\Models\Event;

interface IEventRepository
{
    public function getAll(): array;
    public function getById(int $id): Event;
    public function getByRoomId(int $roomId): array;
    public function getAllEventsNeedingApprovalFrom(int $userId): array;
    public function getAllEventsFrom(int $userId): array;
    public function create(array $event): Event;
    public function assignApprover(int $id, array $approvers): Event;
    public function approve(int $id, int $approverId): Event;
    public function reject(int $id, int $approverId, string $reason): Event;
    public function delete(int $id): void;
    public function getPendingEventsCount(): int;
    public function getApprovedEventsCount(): int;
    public function getRejectedEventsCount(): int;
}