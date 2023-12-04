<?php

namespace Primitives\Models;

enum RoleName: string
{
    case Administrator = "Administrator";
    case Student = "Student";
    case Lecturer = "Lecturer";
}