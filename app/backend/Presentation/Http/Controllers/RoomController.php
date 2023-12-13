<?php

namespace Presentation\Http\Controllers;

use Business\Services\RoomService;
use Presentation\Http\Attributes\Route;
use Presentation\Http\DTO\Room\CreateRoomRequest;
use Presentation\Http\DTO\Room\UpdateRoomRequest;
use Presentation\Http\Helpers\Http;

class RoomController extends Controller
{
    public function __construct(private RoomService $room_service)
    {
    }

    #[Route('/rooms', 'GET')]
    public function getAll(): void
    {
        $rooms = $this->room_service->getAllRooms();
        Http::ok($rooms, "Rooms retrieved successfully");
    }

    #[Route('/room', 'GET')]
    public function getById(): void
    {
        $id = Http::query('id');
        $room = $this->room_service->getRoomById($id);
        Http::ok($room, "Room retrieved successfully");
    }

    #[Route('/rooms/{code}', 'GET')]
    public function getByCode(string $code): void
    {
        $room = $this->room_service->getRoomByCode($code);
        Http::ok($room, "Room retrieved successfully");
    }

    #[Route('/rooms', 'POST')]
    public function create(CreateRoomRequest $room): void
    {
        $room = $this->room_service->createRoom($room->toArray());
        Http::ok($room, "Room created successfully");
    }

    #[Route('/rooms', 'PUT')]
    public function update(UpdateRoomRequest $room): void
    {
        $id = Http::query('id');
        $room = $this->room_service->updateRoom($id, $room->toArray());
        Http::ok($room, "Room updated successfully");
    }

    #[Route('/rooms', 'DELETE')]
    public function delete(): void
    {
        $id = Http::query('id');
        $this->room_service->deleteRoom($id);
        Http::ok(null, "Room deleted successfully");
    }
}