<?php

namespace Primitives\Models;

enum RoleName: string
{
    case Administrator = "ADMIN";
    case Student = "STUDENT";
    case Approver = "APPROVER";
}