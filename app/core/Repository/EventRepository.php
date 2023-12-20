<?php

namespace Repository;

use DateTime;
use Exception;
use Primitives\Models\ApprovalStatus;
use Primitives\Models\Event;
use Primitives\Models\RoleName;
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
            Reason,
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

    public function getAllEventsNeedingApprovalFrom(int $userId): array
    {
        $events = $this->client->executeQuery('
        SELECT
            Event.Id as Id,
            Title,
            Description,
            StartsAt,
            EndsAt,
            Reason,
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
        WHERE EA.UserID = :user_id
        ', ['user_id' => $userId]);

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

    public function getAllEventsFrom(int $userId): array
    {
        $events = $this->client->executeQuery('
        SELECT
            Event.Id as Id,
            Title,
            Description,
            StartsAt,
            EndsAt,
            Reason,
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
        WHERE Event.UserID = :user_id
        ', ['user_id' => $userId]);

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
            Reason,
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
            Reason,
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

    public function getPreviousApproverStatus(int $id, int $approverId): ApprovalStatus
    {
        $status = $this->client->executeQuery('
        SELECT
            Status
        FROM Event_Approver
        WHERE EventID = :event_id AND UserID = (
            SELECT BeforeUserID
            FROM Event_Approver
            WHERE EventID = :ea_event_id AND UserID = :user_id
        )
        ', [
            'event_id' => $id,
            'ea_event_id' => $id,
            'user_id' => $approverId
        ]);
        if (count($status) <= 0) return ApprovalStatus::Unknown;
        return ApprovalStatus::from($status[0]['Status']);
    }

    /**
     * @throws Exception
     */
    public function create(array $event): Event
    {
        $existingEvent = $this->client->executeQuery('
        SELECT
            Event.Id as Id
        FROM 
            Event
        WHERE
            Event.RoomID = :room_id AND
            (
                (:starts_at BETWEEN Event.StartsAt AND Event.EndsAt) OR
                (:ends_at BETWEEN Event.StartsAt AND Event.EndsAt)
            )
        ', [
            'room_id' => $event['room_id'],
            'starts_at' => (new DateTime($event['start_date']))->format('Ymd'),
            'ends_at' => (new DateTime($event['end_date']))->format('Ymd')
        ]);
        if (count($existingEvent) > 0) {
            throw new Exception('Event already exists');
        }

        $this->client->executeNonQuery('
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
            'starts_at' => (new DateTime($event['start_date']))->format('Ymd'),
            'ends_at' => (new DateTime($event['end_date']))->format('Ymd'),
            'room_id' => $event['room_id'],
            'user_id' => $event['user_id']
        ]);
        return $this->getById($this->client->getLastInsertedId());
    }

    /**
     * @throws Exception
     */
    public function isRoomAvailableFromDateRange(int $roomId, string $startDate, string $endDate): array
    {
        return $this->client->executeQuery('
        SELECT
            Event.Id as Id
        FROM 
            Event
        WHERE
            Event.RoomID = :room_id AND
            (
                (:starts_at BETWEEN Event.StartsAt AND Event.EndsAt) OR
                (:ends_at BETWEEN Event.StartsAt AND Event.EndsAt)
            )
        ', [
            'room_id' => $roomId,
            'starts_at' => (new DateTime($startDate))->format('Ymd'),
            'ends_at' => (new DateTime($endDate))->format('Ymd')
        ]);
    }

    public function assignApprover(int $id, array $approvers): Event
    {
        $query = 'INSERT INTO Event_Approver (EventID, UserID, BeforeUserID, AfterUserID, Status) VALUES';
        // append prepared statement template to the query
        foreach ($approvers as $index => $approver) {
            $query .= "(:event_id$index, :user_id$index, :before_user_id$index, :after_user_id$index, :status$index)";
            if ($index !== count($approvers) - 1) {
                $query .= ',';
            }
        }

        $arguments = [];
        foreach ($approvers as $index => $approver) {
            $arguments["event_id$index"] = $id;
            $arguments["user_id$index"] = $approver;
            $arguments["before_user_id$index"] = $approvers[$index - 1] ?? null;
            $arguments["after_user_id$index"] = $approvers[$index + 1] ?? null;
            $arguments["status$index"] = ApprovalStatus::Pending->value;
        }

        $this->client->executeNonQuery($query, $arguments);
        return $this->getById($id);
    }

    public function delete(int $id): void
    {
        $this->client->executeQuery('
            DELETE FROM Event
            WHERE Id = :id
        ', ['id' => $id]);
    }

    public function approve(int $id, int $approverId): Event
    {
        $this->client->executeNonQuery('
            UPDATE Event_Approver
            SET Status = :status
            WHERE EventID = :event_id AND UserID = :user_id
        ', [
            'status' => ApprovalStatus::Approved->value,
            'event_id' => $id,
            'user_id' => $approverId
        ]);

        return $this->getById($id);
    }

    public function reject(int $id, int $approverId, string $reason): Event
    {
        $this->client->executeNonQuery('
            UPDATE Event_Approver
            SET Status = :status, Reason = :reason
            WHERE EventID = :event_id AND UserID = :user_id
        ', [
            'status' => ApprovalStatus::Rejected->value,
            'reason' => $reason,
            'event_id' => $id,
            'user_id' => $approverId
        ]);

        return $this->getById($id);
    }

    private function resolveUserFilterQuery(?int $userId = null, ?RoleName $role = RoleName::Administrator): array
    {
        $filterUserQuery = '';
        $userIdField = '';
        $groupUserQuery = '';
        if ($userId != null && $role == RoleName::Student) {
            $userIdField = 'Event.UserID AS UserID,';
            $filterUserQuery = 'AND UserID = :user_id';
            $groupUserQuery = ', Event.UserID';
        } else if ($role != null && $role == RoleName::Approver) {
            $userIdField = 'EA.UserID AS ApproverID,';
            $filterUserQuery = 'AND ApproverID = :user_id';
            $groupUserQuery = ', EA.UserID';
        }
        return [
            'filterUserQuery' => $filterUserQuery,
            'userIdField' => $userIdField,
            'groupUserQuery' => $groupUserQuery
        ];
    }

    public function getPendingEventsCount(?int $userId = null, ?RoleName $role = RoleName::Administrator): int
    {
        $q = $this->resolveUserFilterQuery($userId, $role);
        return $this->client->executeQuery("
            WITH EventCount AS (
                SELECT
                    Event.Title AS Title,
                    {$q['userIdField']}
                    SUM(IIF(Status = 'PENDING', 1, 0)) AS PendingCount,
                    SUM(IIF(Status = 'APPROVED', 1, 0)) AS ApprovedCount,
                    SUM(IIF(Status = 'REJECTED', 1, 0)) AS RejectedCount
                FROM
                    dbo.[Event]
                LEFT JOIN dbo.Event_Approver EA on Event.Id = EA.EventID
                GROUP BY Event.Id, Event.Title {$q['groupUserQuery']}
            )
            SELECT COUNT(Title) as Count
            FROM EventCount
            WHERE PendingCount > 0 {$q['filterUserQuery']}
        ", $userId != null ? ['user_id' => $userId] : [])[0]['Count'];
    }

    public function getApprovedEventsCount(?int $userId = null, ?RoleName $role = RoleName::Administrator): int
    {
        $q = $this->resolveUserFilterQuery($userId, $role);
        return $this->client->executeQuery("
            WITH EventCount AS (
                SELECT
                    Event.Title AS Title,
                    {$q['userIdField']}
                    SUM(IIF(Status = 'PENDING', 1, 0)) AS PendingCount,
                    SUM(IIF(Status = 'APPROVED', 1, 0)) AS ApprovedCount,
                    SUM(IIF(Status = 'REJECTED', 1, 0)) AS RejectedCount
                FROM
                    dbo.[Event]
                LEFT JOIN dbo.Event_Approver EA on Event.Id = EA.EventID
                GROUP BY Event.Id, Event.Title {$q['groupUserQuery']}
            )
            SELECT COUNT(Title) as Count
            FROM EventCount
            WHERE ApprovedCount > 0 AND PendingCount = 0 AND RejectedCount = 0 {$q['filterUserQuery']}
        ", $userId != null ? ['user_id' => $userId] : [])[0]['Count'];
    }

    public function getRejectedEventsCount(?int $userId = null, ?RoleName $role = RoleName::Administrator): int
    {
        $q = $this->resolveUserFilterQuery($userId, $role);
        return $this->client->executeQuery("
            WITH EventCount AS (
                SELECT
                    Event.Title AS Title,
                    {$q['userIdField']}
                    SUM(IIF(Status = 'PENDING', 1, 0)) AS PendingCount,
                    SUM(IIF(Status = 'APPROVED', 1, 0)) AS ApprovedCount,
                    SUM(IIF(Status = 'REJECTED', 1, 0)) AS RejectedCount
                FROM
                    dbo.[Event]
                LEFT JOIN dbo.Event_Approver EA on Event.Id = EA.EventID
                GROUP BY Event.Id, Event.Title {$q['groupUserQuery']}
            )
            SELECT COUNT(Title) as Count
            FROM EventCount
            WHERE RejectedCount > 0 {$q['filterUserQuery']}
        ", $userId != null ? ['user_id' => $userId] : [])[0]['Count'];
    }
}