<?php

namespace Presentation\Http\Helpers;

class View
{
    /**
     * Automatically loads css files based on the route name
     */
    public static function autoloadCss(): void
    {
        // remove query parameters
        $routeSegments = explode('?', $_SERVER['REQUEST_URI'])[0];
        // explode and remove the admin or lecturer prefix and empty string
        $routeSegments = explode('/', $routeSegments);
        $routeSegments = array_filter($routeSegments, fn($segment) => $segment !== 'admin' && $segment !== 'lecturer' && $segment !== '');
        // use . as a path separator since we can't use / to use it as a file name
        $fileName = implode('.', $routeSegments);
        $fullPath = realpath(dirname(__FILE__) . "/../Views/Assets/css/$fileName.style.css");
        if ($fullPath && file_exists($fullPath)) {
            echo "<link rel='stylesheet' href='/css/$fileName.style.css'>";
        }
    }

    public static function activeClass(string $path): string
    {
        // remove admin or lecturer prefix and empty string
        $routeSegments = explode('/', $_SERVER['REQUEST_URI']);
        $routeSegments = array_filter($routeSegments, fn($segment) => $segment !== 'admin' && $segment !== 'lecturer' && $segment !== '');
        $requestPath = implode('/', $routeSegments);
        error_log($requestPath);
        return $requestPath === $path ? 'active' : '';
    }
}