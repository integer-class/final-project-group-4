<?php

namespace Presentation\Http\Attributes;

/**
 * Marks a method as a route.
 * @param string $path
 * @param string $method
 */
#[\Attribute]
class Route
{
    public string $path;
    public string $method;

    public function __construct(string $path, string $method)
    {
        $this->path = $path;
        $this->method = $method;
    }
}