<?php

namespace RoadMap\Core\Middleware;

use RoadMap\Core\Logger;
use Psr\Log\LoggerInterface;

class LoggingMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Logger::getInstance();
    }

    public function process(callable $next)
    {
        $startTime = microtime(true);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'unknown';
        $uri = $_SERVER['REQUEST_URI'] ?? 'unknown';
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

        $this->logger->info("Запрос: {$method} {$uri}", [
            'ip' => $ip,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);

        $response = $next();

        $duration = round((microtime(true) - $startTime) * 1000, 2);
        $statusCode = http_response_code();

        $this->logger->info("Ответ: {$statusCode} за {$duration} мс", [
            'method' => $method,
            'uri' => $uri,
            'duration_ms' => $duration
        ]);

        return $response;
    }
}