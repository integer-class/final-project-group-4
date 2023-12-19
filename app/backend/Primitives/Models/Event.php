<?php

namespace Primitives\Models;

use DateTime;
use Exception;

class Event
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $startsAt
     * @param DateTime $endsAt
     * @param Room $room
     * @param User $pic
     * @param Approval[] $approvers
     */
    public function __construct(
        public int      $id,
        public string   $title,
        public string   $description,
        public DateTime $startsAt,
        public DateTime $endsAt,
        public Room     $room,
        public User     $pic,
        public array    $approvers,
    )
    {
    }

    public function isApproved(): bool
    {
        foreach ($this->approvers as $approver) {
            if ($approver->status->value != ApprovalStatus::Approved) {
                return false;
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public static function fromArray(array $data, array $approvers): Event
    {
        $hasApprover = array_key_exists('ApproverId', $data) && $data['ApproverId'] != null;
        return new Event(
            id: $data['Id'],
            title: $data['Title'],
            description: $data['Description'],
            startsAt: new DateTime($data['StartsAt']),
            endsAt: new DateTime($data['EndsAt']),
            room: new Room(
                id: $data['RoomId'],
                code: $data['RoomCode'],
                name: $data['RoomName'],
                floor: $data['RoomFloor'],
                capacity: $data['RoomCapacity'],
                side: $data['RoomSide'],
                image: $data['RoomImage'],
            ),
            pic: new User(
                id: $data['PicId'],
                registrationNumber: $data['PicRegistrationNumber'],
                fullname: $data['PicFullName'],
                username: $data['PicUsername'],
                password: null,
                email: $data['PicEmail'],
                phone: $data['PicPhone'],
                avatar: $data['PicAvatar'],
                role: RoleName::from($data['PicRole']),
            ),
            approvers: !$hasApprover ? [] : array_map(fn($approver) => new Approval(
                user: new User(
                    id: $approver['ApproverId'],
                    registrationNumber: $approver['ApproverRegistrationNumber'],
                    fullname: $approver['ApproverFullName'],
                    username: $approver['ApproverUsername'],
                    password: null,
                    email: $approver['ApproverEmail'],
                    phone: $approver['ApproverPhone'],
                    avatar: $approver['ApproverAvatar'],
                    role: RoleName::from($approver['ApproverRole']),
                ),
                status: ApprovalStatus::from($approver['Status']),
                previousApproverId: $approver['BeforeUserId'],
                nextApproverId: $approver['AfterUserId'],
                reason: $approver['Reason'],
            ), $approvers),
        );
    }

    public function getStatus(int $id): ApprovalStatus
    {
        foreach ($this->approvers as $approver) {
            if ($approver->user->id == $id) {
                return $approver->status;
            }
        }
        return ApprovalStatus::Unknown;
    }

    /**
     * @throws Exception
     */
    public function updateWith(array $event): void
    {
        if (isset($event['title']) && $event['title'] !== '') {
            $this->title = $event['title'];
        }

        if (isset($event['description']) && $event['description'] !== '') {
            $this->description = $event['description'];
        }

        if (isset($event['startsAt']) && $event['startsAt'] !== '') {
            $this->startsAt = new DateTime($event['startsAt']);
        }

        if (isset($event['endsAt']) && $event['endsAt'] !== '') {
            $this->endsAt = new DateTime($event['endsAt']);
        }

        if (isset($event['roomId']) && $event['roomId'] !== '') {
            $this->room->id = $event['roomId'];
        }

        if (isset($event['picId']) && $event['picId'] !== '') {
            $this->pic->id = $event['picId'];
        }
    }
}