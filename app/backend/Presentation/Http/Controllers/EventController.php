<?php

namespace Presentation\Http\Controllers;

use Business\Services\EventService;
use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\DTO\Event\CreateEventRequest;
use Presentation\Http\Helpers\Http;
use Primitives\Models\RoleName;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService,
    )
    {
    }

    #[Route('/room/reserve', 'POST')]
    #[WithSession]
    #[Authenticated(RoleName::Student)]
    public function reserve(CreateEventRequest $request): void
    {
        try {
            $event = $this->eventService->createEvent([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'room_id' => $request->room_id,
                'user_id' => $request->user_id,
            ]);
            $_SESSION['success_message'] = 'Event has been reserved successfully';
            Http::redirect("/student/room?id={$event->id}");
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect("/student/room?id={$request->room_id}");
        }
    }
}