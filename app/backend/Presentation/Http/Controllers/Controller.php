<?php

namespace Presentation\Http\Controllers;
abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        $viewPath = realpath(dirname(__FILE__) . '/../Views');

        require_once "$viewPath/Layout/head.page.php";
        require_once "$viewPath/$view.page.php";
        require_once "$viewPath/Layout/foot.page.php";
    }
}