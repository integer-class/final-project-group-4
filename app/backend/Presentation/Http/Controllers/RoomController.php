<?php

namespace Presentation\Http\Controllers;

use Business\Services\RoomService;
use Presentation\Http\Attributes\Route;
use Presentation\Http\DTO\Room\CreateRoomRequest;
use Presentation\Http\DTO\Room\UpdateRoomRequest;
use Presentation\Http\Helpers\Http;

class RoomController extends Controller
{
    public function __construct(private RoomService $roomService)
    {
    }

    #[Route('/rooms', 'GET')]
    public function getAll(): void
    {
        $rooms = $this->roomService->getAllRooms();
        Http::ok($rooms, "Rooms retrieved successfully");
    }

    #[Route('/room', 'GET')]
    public function getById(): void
    {
        $id = Http::query('id');
        $room = $this->roomService->getRoomById($id);
        Http::ok($room, "Room retrieved successfully");
    }

    #[Route('/rooms/{code}', 'GET')]
    public function getByCode(string $code): void
    {
        $room = $this->roomService->getRoomByCode($code);
        Http::ok($room, "Room retrieved successfully");
    }

    #[Route('/rooms', 'POST')]
    public function create(CreateRoomRequest $room): void
    {
        try {
            $room = $this->roomService->createRoom($room->toArray());
            $_SESSION['success_message'] = "Room with an ID of {$room->id} has been created successfully";
            Http::redirect($_SERVER['HTTP_REFERER']);
        Http::ok($room, "Room created successfully");
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect($_SERVER['HTTP_REFERER']);
        }

    }

    #[Route('/rooms', 'PUT')]
    public function update(UpdateRoomRequest $room): void
    {
        $id = Http::query('id');
        $room = $this->roomService->updateRoom($id, $room->toArray());
        $_SESSION['success_message'] = "Room with an ID of {$room->id} has been updated successfully";
        Http::redirect($_SERVER['HTTP_REFERER']);
    }

    #[Route('/rooms', 'DELETE')]
    public function delete(): void
    {
        $id = Http::query('id');
        $this->roomService->deleteRoom($id);
        $_SESSION['success_message'] = "Room deleted successfully";
        Http::redirect($_SERVER['HTTP_REFERER']);
    }
}