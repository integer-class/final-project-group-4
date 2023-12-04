<?php

namespace Presentation\Http\Helpers;

class Http
{
    public static function ok(mixed $data, ?string $message = "OK"): void
    {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message,
            "data" => $data
        ]);
    }

    public static function redirect(string $location): void
    {
        header("Location: $location", true, 302);
    }

    public static function badRequest(?string $message = "Bad Request"): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    public static function unauthorized(?string $message = "Unauthorized"): void
    {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    public static function forbidden(?string $message = "Forbidden"): void
    {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    public static function notFound(?string $message = "Not Found"): void
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    public static function internalServerError(?string $message = "Internal Server Error"): void
    {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }
}