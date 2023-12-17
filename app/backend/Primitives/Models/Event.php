<?php

namespace Primitives\Models;

use DateTime;

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
     * @param Approver[] $approvers
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
            if ($approver->status->value != ApproverStatus::Approved) {
                return false;
            }
        }
        return true;
    }

    /**
     * @throws \Exception
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
                studyProgram: null,
            ),
            approvers: !$hasApprover ? [] : array_map(fn($approver) => new Approver(
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
                    studyProgram: null
                ),
                status: ApproverStatus::from($approver['Status']),
                previousApproverId: $approver['BeforeUserId'],
                nextApproverId: $approver['AfterUserId'],
            ), $approvers),
        );
    }

}