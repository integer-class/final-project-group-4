<?php

namespace Primitives\Models;

enum ApproverStatus: string
{
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case PENDING = 'PENDING';
}

class Approver
{
    public int $id;
    public Event $event;
    public User $user;
    public ApproverStatus $status;
    public ?Approver $previous_approver;
    public ?Approver $next_approver;
}