<?php

namespace Presentation\Http\Controllers;

use Business\Services\EventService;

class EventController
{
    public function __construct(
        private EventService $eventService,
    ) {
    }
}