<?php

namespace Presentation\Http\Attributes;

use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

#[\Attribute]
class Authenticated
{
    public function __construct(private readonly ?RoleName $role)
    {
    }

    public function isAuthenticatedWithRole(): void
    {
        $session = Session::getInstance();
        if (!$session->isSessionStarted()) {
            Http::redirect('/login');
        }

        $role = $session->getRole();

        // ignore checking the role if we don't add the role to this attribute
        if ($this->role === null) return;
        // redirect to home page if the user's role is not the same as the role in this attribute
        if ($role != $this->role) {
            Http::redirect('/');
        }
    }
}