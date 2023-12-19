<?php

namespace Presentation\Http\Controllers;

use Business\Services\EventService;
use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\DTO\Event\AssignApproverRequest;
use Presentation\Http\DTO\Event\CreateEventRequest;
use Presentation\Http\DTO\Event\RejectEventRequest;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

class EventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
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

    #[Route('/event/assign-approver', 'POST')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function assignApprover(AssignApproverRequest $request): void
    {
        try {
            $id = Http::query('id');
            $event = $this->eventService->assignApprover($id, $request->approvers);
            $_SESSION['success_message'] = "The approvers have been assigned for the event {$event->title} successfully";
            Http::redirect("/admin/schedule");
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect("/admin/schedule");
        }
    }

    #[Route('/event/approve', 'POST')]
    #[WithSession]
    #[Authenticated(RoleName::Approver)]
    public function approveEvent(): void
    {
        try {
            $session = Session::getInstance();
            $id = Http::query('id');
            $approverId = $session->user['id'];
            $event = $this->eventService->approve($id, $approverId);
            $_SESSION['success_message'] = "The event {$event->title} has been approved successfully";
            Http::redirect("/approver/schedule");
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect("/approver/schedule");
        }
    }

    #[Route('/event/reject', 'POST')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator, RoleName::Approver)]
    public function rejectEvent(RejectEventRequest $request): void
    {
        try {
            $session = Session::getInstance();
            $id = Http::query('id');
            $approverId = $session->user->id;
            $event = $this->eventService->reject($id, $approverId, $request->reason);
            $_SESSION['success_message'] = "The event {$event->title} has been rejected successfully";
            Http::redirect("/approver/schedule");
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            Http::redirect("/approver/schedule");
        }
    }
}