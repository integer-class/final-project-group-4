<?php

namespace Presentation\Http\Controllers;

use Presentation\Http\Attributes\Route;

class AppController extends Controller
{
    #[Route('/', 'GET')]
    public function index() {
        $this->ok(null, "Hello, 世界!");
    }
}