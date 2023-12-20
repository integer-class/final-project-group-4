<?php

namespace RepositoryInterfaces;

use Primitives\Models\Approval;
use Primitives\Models\ApprovalStatus;
use Primitives\Models\Event;
use Primitives\Models\RoleName;

interface IEventRepository
{
    public function getAll(): array;

    public function getById(int $id): Event;

    public function getByRoomId(int $roomId): array;

    public function getAllEventsNeedingApprovalFrom(int $userId): array;

    public function getAllEventsFrom(int $userId): array;

    public function getPreviousApproverStatus(int $id, int $approverId): ApprovalStatus;

    public function getPendingEventsCount(?int $userId, ?RoleName $role): int;

    public function getApprovedEventsCount(?int $userId, ?RoleName $role): int;

    public function getRejectedEventsCount(?int $userId, ?RoleName $role): int;
    public function isRoomAvailableFromDateRange(int $roomId, string $startDate, string $endDate): array;

    public function create(array $event): Event;

    public function assignApprover(int $id, array $approvers): Event;

    public function approve(int $id, int $approverId): Event;

    public function reject(int $id, int $approverId, string $reason): Event;

    public function delete(int $id): void;

}