<?php

namespace Presentation\Http\Helpers;

class Http
{
    /**
     * Sends a JSON response with the given data using the 200 status code.
     * @param mixed $data
     * @param string|null $message
     * @return void
     */
    public static function ok(mixed $data, ?string $message = "OK"): void
    {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Sends a redirect response to the given location with the 302 status code.
     * @param string $location
     * @return void
     */
    public static function redirect(string $location): void
    {
        header("Location: $location", true, 302);
    }

    /**
     * Extracts the query string value from the URL.
     * @param string $key
     * @return mixed
     */
    public static function query(string $key): mixed
    {
        return $_GET[$key];
    }

    /**
     * Sends a JSON response with the given data using the 404 status code.
     * @param string|null $message
     * @return void
     */
    public static function notFound(?string $message = "Not Found"): void
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    /**
     * Sends a JSON response with the given data using the 500 status code.
     * @param string|null $message
     * @return void
     */
    public static function internalServerError(?string $message = "Internal Server Error"): void
    {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }
}