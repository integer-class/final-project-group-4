<?php

namespace Presentation\Http\Controllers;
abstract class Controller
{
    /**
     * Helpers to send a response with a 200 status code and a JSON body.
     */
    protected function ok(mixed $data, ?string $message = "OK"): void
    {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message,
            "data" => $data
        ]);
    }

    protected function redirect(string $location): void
    {
        header("Location: $location");
    }

    protected function badRequest(?string $message = "Bad Request"): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function view(string $view, array $data = []): void
    {
        $viewPath = realpath(dirname(__FILE__) . '/../Views');

        require_once "$viewPath/Layout/head.page.php";
        require_once "$viewPath/$view.page.php";
        require_once "$viewPath/Layout/foot.page.php";
    }

    protected function unauthorized(?string $message = "Unauthorized"): void
    {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function forbidden(?string $message = "Forbidden"): void
    {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function notFound(?string $message = "Not Found"): void
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function internalServerError(?string $message = "Internal Server Error"): void
    {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }
}