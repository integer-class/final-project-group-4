<?php

namespace Presentation\Http\Helpers;

class View
{
    /**
     * @return string[]
     */
    private static function getRouteSegments(): array
    {
        // remove query parameters
        $routeSegments = explode('?', $_SERVER['REQUEST_URI'])[0];
        // explode and remove the admin or approver prefix and empty string
        $routeSegments = explode('/', $routeSegments);
        return (array)array_filter($routeSegments, fn($segment) => $segment !== 'admin' &&
            $segment !== 'approver' &&
            $segment !== 'student' &&
            $segment !== '');
    }

    /**
     * Automatically loads css files based on the route name
     */
    public static function autoloadCss(): void
    {
        $routeSegments = self::getRouteSegments();
        // use . as a path separator since we can't use / to use it as a file name
        $fileName = implode('.', $routeSegments);
        $fullPath = realpath(dirname(__FILE__) . "/../Views/Assets/css/$fileName.style.css");
        if ($fullPath && file_exists($fullPath)) {
            echo "<link rel='stylesheet' href='/css/$fileName.style.css'>";
        }
    }

    public static function activeClass(string $path): string
    {
        $routeSegments = self::getRouteSegments();
        $requestPath = implode('/', $routeSegments);
        error_log($requestPath);
        return $requestPath === $path ? 'active' : '';
    }
}