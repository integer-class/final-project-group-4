<?php

// autoload classes using psr-4 convention
spl_autoload_register(function ($class) {
    $class_path = str_replace('\\', '/', $class);

    $file = __DIR__ . '/' . $class_path . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});