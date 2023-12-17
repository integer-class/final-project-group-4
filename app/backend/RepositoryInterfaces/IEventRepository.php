<?php

namespace RepositoryInterfaces;

use Primitives\Models\Event;

interface IEventRepository
{
    public function getAll(): array;
    public function getById(int $id): Event;
    public function getByRoomId(int $roomId): array;
    public function create(array $event): Event;
    public function updateApprover(Event $event, array $approvers): Event;
    public function updateStatus(Event $event, int $userId, string $eventStatus): Event;
    public function delete(int $id): void;
    public function getPendingEventsCount(): int;
    public function getApprovedEventsCount(): int;
    public function getRejectedEventsCount(): int;
}