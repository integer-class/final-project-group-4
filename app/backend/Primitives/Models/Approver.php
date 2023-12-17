<?php

namespace Primitives\Models;

class Approver
{
    public function __construct(
        public User           $user,
        public ApproverStatus $status,
        public ?int      $previousApproverId,
        public ?int      $nextApproverId
    )
    {
    }
}