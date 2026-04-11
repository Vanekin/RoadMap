<?php

namespace RoadMap\Core;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Logger {
    private static ?Logger $instance = null;
    private MonologLogger $logger;
    private string $logPath;
    private function __construct() {
        $this->logPath = __DIR__ . '/../../runtime/logs/app.log';
        $logDir = dirname($this->logPath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $this->logger = new MonologLogger('RoadMap');
        $this->logger->pushHandler(new StreamHandler($this->logPath, Level::Info));
    }
    public static function getInstance(): Logger {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function debug(string $message, array $context = []): void {
        $this->logger->debug($message, $this->enrichContext($context));
    }
    public function info(string $message, array $context = []): void {
        $this->logger->info($message, $this->enrichContext($context));
    }
    public function warning(string $message, array $context = []): void {
        $this->logger->warning($message, $this->enrichContext($context));
    }
    public function error(string $message, array $context = []): void {
        $this->logger->error($message, $this->enrichContext($context));
    }
    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $this->enrichContext($context));
    }
    private function enrichContext(array $context): array
    {
        $context['ip'] = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $context['uri'] = $_SERVER['REQUEST_URI'] ?? 'unknown';
        $context['method'] = $_SERVER['REQUEST_METHOD'] ?? 'unknown';

        return $context;
    }
}