<?php

namespace Primitives\Models;

class Approver
{
    public function __construct(
        public int            $id,
        public Event          $event,
        public User           $user,
        public ApproverStatus $status,
        public ?Approver      $previous_approver,
        public ?Approver      $next_approver
    )
    {
    }
}