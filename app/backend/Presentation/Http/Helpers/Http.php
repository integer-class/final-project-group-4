<?php

namespace Presentation\Http\Helpers;

use Exception;

class Http
{
    private static int $FILE_UPLOAD_SIZE = 5_000_000; // 5MB

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

    public static function query(string $key): mixed
    {
        return $_GET[$key];
    }

    /**
     * @throws Exception
     */
    public static function getAsset(string $name): string
    {
        $file = $_FILES[$name];

        if (!$file) {
            throw new Exception("File not found");
        }

        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_error = $file['error'];
        $file_size = $file['size'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = ['png', 'jpg', 'jpeg', 'gif'];

        if ($file_error !== 0) {
            throw new Exception("Error uploading file");
        }

        if (!in_array($file_ext, $allowed)) {
            throw new Exception("File type not allowed");
        }

        if ($file_size > self::$FILE_UPLOAD_SIZE) {
            throw new Exception("File size too large");
        }

        $file_name_new = uniqid('', true) . '.' . $file_ext;
        $file_destination = __DIR__ . "/../Views/Assets/uploaded_images/$file_name_new";

        if (!move_uploaded_file($file_tmp, $file_destination)) {
            throw new Exception("Error moving file");
        }

        return "/uploaded_images/$file_name_new";
    }

    /**
     * @throws Exception
     */
    public static function updateAsset(string $name, string $old_path): string
    {
        unlink(__DIR__ . "/../Views/Assets/$old_path");
        return self::getAsset($name);
    }

    public static function created(mixed $data, ?string $message = "Created"): void
    {
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message,
            "data" => $data
        ]);
    }

    public static function badRequest(array $errors = [], ?string $message = "Bad Request"): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message,
            "errors" => $errors
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