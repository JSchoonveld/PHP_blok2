<?php

function require_class($name)
{
    if(!file_exists(__DIR__ . '/../' . $name . '.php')) {
        throw new Exception('This file does not exist: ' . __DIR__ . '/../' . $name . '.php');
    }

    require_once __DIR__ . '/../' . $name . '.php';
}

function show_exception($exception)
{
    $message =
        [
            '<strong>Error:</strong>' . PHP_EOL . $exception->getMessage(),
            '<strong>File:</strong>' . PHP_EOL . $exception->getFile(),
            '<strong>Line:</strong>' . PHP_EOL . $exception->getLine(),
            '<strong>Trace:</strong>' . PHP_EOL . $exception->getTraceAsString(),
        ];

    echo nl2br(join(PHP_EOL.PHP_EOL, $message));
}

set_exception_handler('show_exception');
spl_autoload_register('require_class');
