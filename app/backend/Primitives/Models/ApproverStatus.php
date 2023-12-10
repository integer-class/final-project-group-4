<?php

namespace Primitives\Models;

enum ApproverStatus: string
{
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case PENDING = 'PENDING';
}