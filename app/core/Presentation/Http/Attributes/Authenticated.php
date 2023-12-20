<?php

namespace Presentation\Http\Attributes;

use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

/**
 * Guards a route to only allow authenticated users to access it.
 * If the user is not authenticated, it will redirect to the login page.
 * If the user is authenticated but does not have the required role, it will redirect to the home page.
 * @param RoleName ...$role
 */
#[\Attribute]
class Authenticated
{
    /** @var RoleName[] $allowedRoles */
    private array $allowedRoles = [];

    public function __construct(...$role)
    {
        foreach ($role as $r) {
            if ($r instanceof RoleName) {
                $this->allowedRoles[] = $r;
            }
        }
    }

    public function isAuthenticatedWithRole(): void
    {
        $session = Session::getInstance();
        if (!$session->isSessionStarted()) {
            Http::redirect('/login');
        }

        $role = $session->user?->role;

        // ignore checking the role if we don't add the role to this attribute
        if (count($this->allowedRoles) <= 0) return;

        // redirect to home page if the user's role is not the same as the role in this attribute
        if (!in_array($role, $this->allowedRoles)) {
            Http::redirect('/');
        }
    }
}