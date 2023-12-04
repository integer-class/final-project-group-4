<?php

namespace Presentation\Http\Attributes;

use Presentation\Http\Helpers\Session;

#[\Attribute]
class WithSession
{
    public function startSession(): void
    {
        $session = Session::getInstance();
        $session->startSession();
    }
}