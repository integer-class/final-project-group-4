<?php

namespace Repository;

use Primitives\Models\Room;
use Primitives\Models\User;
use RepositoryInterfaces\IRoomRepository;

class RoomRepository implements IRoomRepository
{
    public function __construct(private readonly MssqlClient $mssqlClient)
    {
    }

    public function getAll(): array
    {
        $rows = $this->mssqlClient->executeQuery("
            SELECT
                ID,
                Code,
                Name,
                Floor,
                FloorPlanIndex,
                Capacity,
                Side
            FROM
                dbo.Room
        ");

        return array_map(fn($user) => User::fromArray($user), $rows);
    }

    public function getById(int $id): Room
    {
        $row = $this->mssqlClient->executeQuery("
            SELECT
                ID,
                Code,
                Name,
                Floor,
                FloorPlanIndex,
                Capacity,
                Side
            FROM
                dbo.Room
            WHERE
                ID = $id
        ")[0];

        return Room::fromArray($row);
    }

    public function getByCode(string $code): Room
    {
        $row = $this->mssqlClient->executeQuery("
            SELECT
                ID,
                Code,
                Name,
                Floor,
                FloorPlanIndex,
                Capacity,
                Side
            FROM
                dbo.Room
            WHERE
                Code = '$code'
        ")[0];

        return Room::fromArray($row);
    }

    public function create(Room $room): Room
    {
        $this->mssqlClient->executeQuery("
            INSERT INTO dbo.Room (Code, Name, Floor, FloorPlanIndex, Capacity, Side)
            VALUES (:code, :name, :floor, :floor_plan_index, :capacity, :side)
        ", [
            'code' => $room->code,
            'name' => $room->name,
            'floor' => $room->floor,
            'floor_plan_index' => $room->floor_plan_index,
            'capacity' => $room->capacity,
            'side' => $room->side
        ]);

        return $room;
    }

    public function update(Room $room): Room
    {
        $this->mssqlClient->executeQuery("
            UPDATE dbo.Room
            SET Code = :code, Name = :name, Floor = :floor, FloorPlanIndex = :floor_plan_index, Capacity = :capacity, Side = :side
            WHERE ID = :id
        ", [
            'id' => $room->id,
            'code' => $room->code,
            'name' => $room->name,
            'floor' => $room->floor,
            'floor_plan_index' => $room->floor_plan_index,
            'capacity' => $room->capacity,
            'side' => $room->side
        ]);

        return $room;
    }

    public function delete(int $id): void
    {
        $this->mssqlClient->executeQuery("
            DELETE FROM dbo.Room
            WHERE ID = :id
        ", [
            'id' => $id
        ]);
    }
}