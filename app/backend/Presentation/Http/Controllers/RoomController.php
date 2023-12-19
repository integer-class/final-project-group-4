<?php

namespace Presentation\Http\Controllers;

use Business\Services\RoomService;
use Presentation\Http\Attributes\Route;
use Presentation\Http\DTO\Room\CreateRoomRequest;
use Presentation\Http\DTO\Room\UpdateRoomRequest;
use Presentation\Http\Helpers\Http;

class RoomController extends Controller
{
    public function __construct(private readonly RoomService $roomService)
    {
    }

    #[Route('/rooms/search', 'GET')]
    public function searchRoom(): void
    {
        $query = Http::query('query');
        $rooms = $this->roomService->searchRoom($query);
        Http::ok($rooms, "Room retrieved successfully");
    }

    #[Route('/rooms', 'POST')]
    public function create(CreateRoomRequest $room): void
    {
        try {
            $room = $this->roomService->createRoom($room->toArray());
            $_SESSION['success_message'] = "Room with the name of {$room->name} has been created successfully";
            Http::redirect("/admin/room-list");
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect('/admin/room-list');
        }

    }

    #[Route('/rooms', 'PUT')]
    public function update(UpdateRoomRequest $room): void
    {
        try {
            $room = $this->roomService->updateRoom($room->toArray());
            $_SESSION['success_message'] = "Room with the name of {$room->name} has been updated successfully";
            Http::redirect('/admin/room-list');
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect('/admin/room-list');
        }
    }

    #[Route('/rooms', 'DELETE')]
    public function delete(): void
    {
        try {
            $id = Http::query('id');
            $this->roomService->deleteRoom($id);
            $_SESSION['success_message'] = "Room deleted successfully";
            Http::redirect($_SERVER['HTTP_REFERER']);
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect('/admin/room-list');
        }
    }
}