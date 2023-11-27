<?php

namespace Presentation\Http\Attributes;

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