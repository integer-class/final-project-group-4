<?php

namespace Presentation\Http;

use Presentation\Http\Attributes\Route;
use Presentation\Http\Controllers\Controller;

class HttpPresenter
{
    /* @var $controllers Controller[] */
    private array $controllers = [];

    public function register(Controller $controller): void
    {
        $this->controllers[] = $controller;
    }

    public function run(): void
    {
        $request_path = $_SERVER['REQUEST_URI'];
        $request_method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->controllers as $controller) {
            $reflection = new \ReflectionClass($controller);
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    if ($route->path === $request_path && $route->method === $request_method) {
                        try {
                            if ($request_method === "POST" || $request_method === "PUT") {
                                $body = $this->extractRequestBody();
                                if ($body === null) {
                                    $this->badRequest("Body can't be empty!");
                                    return;
                                }
                                $dto = $method->getParameters()[0]->getType()->getName();
                                $body = new $dto($body);
                                $method->invoke($controller, $body);
                            } else {
                                $method->invoke($controller);
                            }
                        } catch (\ReflectionException $e) {
                            $this->internalServerError($e->getMessage());
                        }
                        return;
                    }
                }
            }
        }

        // try to resolve asset path for any routes that is not registered
        $asset_path = dirname(__FILE__) . '/Views/Assets' . $request_path;
        if (file_exists($asset_path)) {
            if (str_ends_with($asset_path, 'css')) {
                header('Content-Type: text/css');
            } else {
                header('Content-Type: ' . mime_content_type($asset_path));
            }
            readfile($asset_path);
            return;
        }

        // by default send not found response if no route is found
        $this->notFound();
    }

    private function internalServerError(?string $message = "Internal Server Error"): void
    {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    private function badRequest(?string $message = "Bad Request"): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    private function notFound(?string $message = "Not Found"): void
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            "message" => $message
        ]);
    }

    private function extractRequestBody(): mixed
    {
        $body = file_get_contents('php://input');
        return json_decode($body, true);
    }
}