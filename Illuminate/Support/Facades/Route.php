<?php

namespace Illuminate\Support\Facades;

class PendingRoute
{
    public function name($name): self
    {
        return $this;
    }
}

class Route
{
    public static function get($uri, $action)
    {
        return new PendingRoute();
    }

    public static function post($uri, $action)
    {
        return new PendingRoute();
    }

    public static function put($uri, $action)
    {
        return new PendingRoute();
    }

    public static function delete($uri, $action)
    {
        return new PendingRoute();
    }

    public static function middleware($middleware)
    {
        return new static();
    }

    public function group($callback)
    {
        if (is_callable($callback)) {
            $callback();
        }
        return $this;
    }
}
