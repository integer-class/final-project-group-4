<?php

namespace Business\Services;

use Presentation\Http\Helpers\Storage;
use Primitives\Models\Room;
use RepositoryInterfaces\IRoomRepository;

class RoomService
{
    public function __construct(private readonly IRoomRepository $roomRepository)
    {
    }

    public function getAllRooms(): array
    {
        return $this->roomRepository->getAll();
    }

    public function getRoomById(int $id): Room
    {
        return $this->roomRepository->getById($id);
    }

    public function getRoomByCode(string $code): Room
    {
        return $this->roomRepository->getByCode($code);
    }

    /**
     * @throws \Exception
     */
    public function createRoom(array $raw_room): Room
    {
        $image = Storage::handleUploadedImage('image', 'room');
        $room = new Room(
            id: null,
            code: $raw_room['code'],
            name: $raw_room['name'],
            floor: $raw_room['floor'],
            capacity: $raw_room['capacity'],
            side: $raw_room['side'],
            image: $image,
        );
        try {
            return $this->roomRepository->create($room);
        } catch (\Exception $ex) {
            Storage::removeStoredImage("room/$image");
            throw new \Exception($ex->getMessage());
        }
    }

    public function updateRoom(string $id, array $raw_room): Room
    {
        $room = new Room(
            id: $id,
            code: $raw_room['code'],
            name: $raw_room['name'],
            floor: $raw_room['floor'],
            capacity: $raw_room['capacity'],
            side: $raw_room['side'],
            image: $raw_room['image']
        );
        return $this->roomRepository->update($room);
    }

    public function deleteRoom(string $id): void
    {
        $room = $this->roomRepository->getById($id);
        Storage::removeStoredImage("room/$room->image");
        $this->roomRepository->delete($id);
    }

    public function getRoomsCount(): int
    {
        return $this->roomRepository->getCount();
    }
}