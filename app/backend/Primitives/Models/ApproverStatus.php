<?php

namespace Primitives\Models;

enum ApproverStatus: string
{
    case Approved = 'APPROVED';
    case Rejected = 'REJECTED';
    case Pending = 'PENDING';
}