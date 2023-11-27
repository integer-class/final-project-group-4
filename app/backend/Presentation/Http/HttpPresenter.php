<?php

namespace Presentation\Http;

use Presentation\Http\Attributes\Route;
use Presentation\Http\Controllers\Controller;
use ReflectionClass;

class HttpPresenter
{
    /* @var $controllers Controller[] */
    private array $controllers = [];

    public function register(Controller $controller)
    {
        $this->controllers[] = $controller;
    }

    public function run()
    {
        $request_path = $_SERVER['PATH_INFO'];
        // if request path is empty, set it to root
        if ($request_path === "") {
            $request_path = "/";
        }
        $request_method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->controllers as $controller) {
            $reflection = new ReflectionClass($controller);
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    if ($route->path === $request_path && $route->method === $request_method) {
                        try {
                            $method->invoke($controller);
                        } catch (ReflectionException $e) {
                            header("Content-Type: application/json");
                            http_response_code(500);
                            echo json_encode([
                                "message" => "Internal Server Error"
                            ]);
                        }
                    }
                }
            }
        }
    }
}