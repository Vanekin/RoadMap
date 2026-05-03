<?php

namespace RoadMap\Core\Middleware;

interface MiddlewareInterface
{
    public function process(callable $next);
}