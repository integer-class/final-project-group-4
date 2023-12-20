<?php

namespace Presentation\Http\Attributes;

use Presentation\Http\Helpers\Session;

/**
 * Starts a session.
 */
#[\Attribute]
class WithSession
{
    public function startSession(): void
    {
        $session = Session::getInstance();
        $session->startSession();
    }
}