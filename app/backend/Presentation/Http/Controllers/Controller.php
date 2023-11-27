<?php

namespace Presentation\Http\Controllers;
abstract class Controller
{
    /**
     * Helpers to send a response with a 200 status code and a JSON body.
     */
    protected function ok(mixed $data, ?string $message = "OK")
    {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message,
            "data" => $data
        ]);
    }

    protected function badRequest(?string $message = "Bad Request")
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function unauthorized(?string $message = "Unauthorized")
    {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function forbidden(?string $message = "Forbidden")
    {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function notFound(?string $message = "Not Found")
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    protected function internalServerError(?string $message = "Internal Server Error")
    {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }
}