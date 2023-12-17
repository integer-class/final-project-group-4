<?php

namespace Repository;

use Primitives\Models\Event;
use RepositoryInterfaces\IEventRepository;

class EventRepository implements IEventRepository
{
    public function __construct(private readonly MssqlClient $client)
    {
    }

    public function getAll(): array
    {
        $events = $this->client->executeQuery('
        SELECT
            Event.Id as Id,
            Title,
            Description,
            StartsAt,
            EndsAt,
            PIC.Id                 as PicId,
            PIC.FullName           as PicFullName,
            PIC.RegistrationNumber as PicRegistrationNumber,
            PIC.Username           as PicUsername,
            PIC.Email              as PicEmail,
            PIC.Phone              as PicPhone,
            PIC.Avatar             as PicAvatar,
            PIC.Role               as PicRole,
            U.Id                   as ApproverId,
            U.FullName             as ApproverFullName,
            U.RegistrationNumber   as ApproverRegistrationNumber,
            U.Username             as ApproverUsername,
            U.Email                as ApproverEmail,
            U.Phone                as ApproverPhone,
            U.Avatar               as ApproverAvatar,
            U.Role                 as ApproverRole,
            BU.Id                  as BeforeUserId,
            AU.Id                  as AfterUserId,
            EA.Status              as Status,
            R.Id                   as RoomId,
            R.Code                 as RoomCode,
            R.Name                 as RoomName,
            R.Capacity             as RoomCapacity,
            R.Floor                as RoomFloor,
            R.Side                 as RoomSide,
            R.Image                as RoomImage
        FROM Event
             LEFT JOIN dbo.Event_Approver EA on Event.Id = EA.EventID
             LEFT JOIN dbo.[User] PIC on Event.UserID = PIC.Id
             LEFT JOIN dbo.[User] U on EA.UserID = U.Id
             LEFT JOIN dbo.[User] BU on EA.BeforeUserID = BU.Id
             LEFT JOIN dbo.[User] AU on EA.AfterUserID = AU.Id
             LEFT JOIN dbo.[Room] R on Event.RoomID = R.Id
        ');

        // group by event id before mapping to event object
        $events = array_reduce($events, function ($carry, $event) {
            $carry[$event['Id']][] = $event;
            return $carry;
        }, []);

        // map each event ids to event object with their first event as the main event and the rest as the approver
        return array_map(function ($event) {
            $main_event = $event[0];
            return Event::fromArray($main_event, $event);
        }, $events);
    }

    public function getById(int $id): Event
    {
        $events = $this->client->executeQuery('
        SELECT
            Event.Id as Id,
            Title,
            Description,
            StartsAt,
            EndsAt,
            PIC.Id                 as PicId,
            PIC.FullName           as PicFullName,
            PIC.RegistrationNumber as PicRegistrationNumber,
            PIC.Username           as PicUsername,
            PIC.Email              as PicEmail,
            PIC.Phone              as PicPhone,
            PIC.Avatar             as PicAvatar,
            PIC.Role               as PicRole,
            U.Id                   as ApproverId,
            U.FullName             as ApproverFullName,
            U.RegistrationNumber   as ApproverRegistrationNumber,
            U.Username             as ApproverUsername,
            U.Email                as ApproverEmail,
            U.Phone                as ApproverPhone,
            U.Avatar               as ApproverAvatar,
            U.Role                 as ApproverRole,
            BU.Id                  as BeforeUserId,
            AU.Id                  as AfterUserId,
            EA.Status              as Status,
            R.Id                   as RoomId,
            R.Code                 as RoomCode,
            R.Name                 as RoomName,
            R.Capacity             as RoomCapacity,
            R.Floor                as RoomFloor,
            R.Side                 as RoomSide,
            R.Image                as RoomImage
        FROM Event
             LEFT JOIN dbo.Event_Approver EA on Event.Id = EA.EventID
             LEFT JOIN dbo.[User] PIC on Event.UserID = PIC.Id
             LEFT JOIN dbo.[User] U on EA.UserID = U.Id
             LEFT JOIN dbo.[User] BU on EA.BeforeUserID = BU.Id
             LEFT JOIN dbo.[User] AU on EA.AfterUserID = AU.Id
             LEFT JOIN dbo.[Room] R on Event.RoomID = R.Id
        WHERE Event.Id = :id
        ', ['id' => $id]);

        return Event::fromArray($events[0], $events);
    }

    public function getByRoomId(int $roomId): array
    {
        $events = $this->client->executeQuery('
        SELECT
            Event.Id as Id,
            Title,
            Description,
            StartsAt,
            EndsAt,
            PIC.Id                 as PicId,
            PIC.FullName           as PicFullName,
            PIC.RegistrationNumber as PicRegistrationNumber,
            PIC.Username           as PicUsername,
            PIC.Email              as PicEmail,
            PIC.Phone              as PicPhone,
            PIC.Avatar             as PicAvatar,
            PIC.Role               as PicRole,
            U.Id                   as ApproverId,
            U.FullName             as ApproverFullName,
            U.RegistrationNumber   as ApproverRegistrationNumber,
            U.Username             as ApproverUsername,
            U.Email                as ApproverEmail,
            U.Phone                as ApproverPhone,
            U.Avatar               as ApproverAvatar,
            U.Role                 as ApproverRole,
            BU.Id                  as BeforeUserId,
            AU.Id                  as AfterUserId,
            EA.Status              as Status,
            R.Id                   as RoomId,
            R.Code                 as RoomCode,
            R.Name                 as RoomName,
            R.Capacity             as RoomCapacity,
            R.Floor                as RoomFloor,
            R.Side                 as RoomSide,
            R.Image                as RoomImage
        FROM Event
             LEFT JOIN dbo.Event_Approver EA on Event.Id = EA.EventID
             LEFT JOIN dbo.[User] PIC on Event.UserID = PIC.Id
             LEFT JOIN dbo.[User] U on EA.UserID = U.Id
             LEFT JOIN dbo.[User] BU on EA.BeforeUserID = BU.Id
             LEFT JOIN dbo.[User] AU on EA.AfterUserID = AU.Id
             LEFT JOIN dbo.[Room] R on Event.RoomID = R.Id
        WHERE Event.RoomID = :room_id
        ', ['room_id' => $roomId]);

        // group by event id before mapping to event object
        $events = array_reduce($events, function ($carry, $event) {
            $carry[$event['Id']][] = $event;
            return $carry;
        }, []);

        // map each event ids to event object with their first event as the main event and the rest as the approver
        return array_map(function ($event) {
            return Event::fromArray($event[0], $event);
        }, $events);
    }

    public function create(array $event): Event
    {
        $this->client->executeQuery('
        INSERT INTO Event
        (
            Title,
            Description,
            StartsAt,
            EndsAt,
            RoomID,
            UserID
        )
        VALUES
        (
            :title,
            :description,
            :starts_at,
            :ends_at,
            :room_id,
            :user_id
        )', [
            'title' => $event['title'],
            'description' => $event['description'],
            'starts_at' => $event['starts_at']->format('Ymd'),
            'ends_at' => $event['ends_at']->format('Ymd'),
            'room_id' => $event['room_id'],
            'user_id' => $event['user_id']
        ]);
        return $this->getById($this->client->getLastInsertedId());
    }

    public function delete(int $id): void
    {
        $this->client->executeQuery('
            DELETE FROM Event
            WHERE Id = :id
        ', ['id' => $id]);
    }

    public function updateApprover(Event $event, array $approvers): Event
    {
        $query = 'INSERT INTO Event_Approver (EventID, UserID, BeforeUserID, AfterUserID, Status) VALUES';
        // append prepared statement template to the query
        foreach ($approvers as $index => $approver) {
            $query .= "(:event_id$index, :user_id$index, :before_user_id$index, :after_user_id$index, :status$index)";
            if ($index !== count($approvers) - 1) {
                $query .= ',';
            }
        }
    }

    public function updateStatus(Event $event, int $userId, string $eventStatus): Event
    {
        // TODO: Implement updateStatus() method.
    }
}