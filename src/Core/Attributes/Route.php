<?php

namespace RoadMap\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public string $path,
        public string|array $method = 'GET'
    ) {
    }
}
