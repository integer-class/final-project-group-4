<?php

namespace Presentation\Http\Helpers;

use Primitives\Models\RoleName;

class View
{
    /**
     * Gets the route segments from the request uri
     * @return array<string>
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

    /**
     * Returns an 'active' class when the current route matches the given path
     */
    public static function activeClass(string $path): string
    {
        $routeSegments = self::getRouteSegments();
        $requestPath = implode('/', $routeSegments);
        return $requestPath === $path ? 'active' : '';
    }

    /**
     * Returns the route based on the user's role
     */
    public static function route(string $path): string
    {
        $session = Session::getInstance();
        $user = $session->user;
        $prefix = "";

        switch ($user->role) {
            case RoleName::Administrator:
                $prefix = "/admin";
                break;
            case RoleName::Approver:
                $prefix = "/approver";
                break;
            case RoleName::Student:
                $prefix = "/student";
                break;
        }

        return "{$prefix}/{$path}";
    }

    public static function flashMessages(): ?string
    {
        $session = Session::getInstance();

        if (isset($session->success_message)) {
            $message = $session->success_message;
            unset($session->success_message);
            return <<<HTML
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {$message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            HTML;
        }

        if (isset($session->error_message)) {
            $message = $session->error_message;
            unset($session->error_message);
            return <<<HTML
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {$message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            HTML;
        }

        return null;
    }
}