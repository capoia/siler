<?php
/**
 * Siler routing facilities
 */

namespace Siler\Route;

use Siler\Http;
use function Siler\require_fn;

/**
 * Define a new route
 *
 * @param string $method The HTTP request method to listen on
 * @param string $path The HTTP URI to listen on
 * @param string|callable $callback The callable to be executed or a string to be used with Siler\require_fn
 */
function route($method, $path, $callback)
{
    $path = regexify($path);

    if (is_string($callback)) {
        $callback = require_fn($callback);
    }

    if (Http\method_is($method) && preg_match($path, Http\path(), $params)) {
        $callback($params);
    }
}

/**
 * Turns a URLroute path into a Regexp
 *
 * @param string $path The HTTP path
 *
 * @return string
 */
function regexify($path)
{
    $path = preg_replace('/\{([A-z-]+)\}/', '(?<$1>[A-z0-9_-]+)', $path);
    $path = "#^{$path}/?$#";

    return $path;
}
