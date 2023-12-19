<?php

namespace Primitives\Models;

enum ApprovalStatus: string
{
    case Approved = 'APPROVED';
    case Rejected = 'REJECTED';
    case Pending = 'PENDING';
    case Unknown = 'UNKNOWN';
}