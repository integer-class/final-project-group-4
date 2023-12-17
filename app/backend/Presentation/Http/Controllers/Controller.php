<?php

namespace Presentation\Http\Controllers;
abstract class Controller
{
    protected function view(string $view, array $data = [], bool $withLayout = true): void
    {
        $viewPath = realpath(dirname(__FILE__) . '/../Views');

        // expose data to view
        extract($data);

        if (!$withLayout) {
            require_once "$viewPath/$view.page.php";
            return;
        }

        require_once "$viewPath/Layout/head.page.php";
        require_once "$viewPath/$view.page.php";
        require_once "$viewPath/Layout/foot.page.php";
    }
}