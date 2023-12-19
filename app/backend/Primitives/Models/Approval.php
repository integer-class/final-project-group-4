<?php

namespace Primitives\Models;

class Approval
{
    public function __construct(
        public User           $user,
        public ApprovalStatus $status,
        public ?int           $previousApproverId,
        public ?int           $nextApproverId,
        public ?string        $reason,
    )
    {
    }
}