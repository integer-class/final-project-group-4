<?php

namespace Presentation\Http\Controllers;

use Presentation\Http\Attributes\Route;

class AppController extends Controller
{
    #[Route('/', 'GET')]
    public function index() {
        $this->redirect('/login');
    }

    #[Route('/login', 'GET')]
    public function login() {
        $this->view('login', [
            '__layout_title__' => 'Login'
        ]);
    }
}