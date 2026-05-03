<?php

namespace RoadMap\Core;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Logger implements LoggerInterface
{
    private static ?self $instance = null;
    private MonologLogger $logger;
    private string $logPath;
    private function __construct()
    {
        $this->logPath = __DIR__ . '/../../runtime/logs/app.log';
        $logDir = dirname($this->logPath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $this->logger = new MonologLogger('RoadMap');
        $this->logger->pushHandler(new StreamHandler($this->logPath, Level::Info));
    }
    public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function setDebugMode(bool $debug): void
    {
        $level = $debug ? Level::Debug : Level::Info;
        $this->logger = new MonologLogger('RoadMap');
        $this->logger->pushHandler(new StreamHandler($this->logPath, $level));
    }
    public function emergency($message, array $context = []): void
    {
        $this->logger->emergency($message, $this->enrichContext($context));
    }

    public function alert($message, array $context = []): void
    {
        $this->logger->alert($message, $this->enrichContext($context));
    }

    public function critical($message, array $context = []): void
    {
        $this->logger->critical($message, $this->enrichContext($context));
    }

    public function error($message, array $context = []): void
    {
        $this->logger->error($message, $this->enrichContext($context));
    }

    public function warning($message, array $context = []): void
    {
        $this->logger->warning($message, $this->enrichContext($context));
    }

    public function notice($message, array $context = []): void
    {
        $this->logger->notice($message, $this->enrichContext($context));
    }

    public function info($message, array $context = []): void
    {
        $this->logger->info($message, $this->enrichContext($context));
    }

    public function debug($message, array $context = []): void
    {
        $this->logger->debug($message, $this->enrichContext($context));
    }

    public function log($level, $message, array $context = []): void
    {
        $this->logger->log($level, $message, $this->enrichContext($context));
    }

    private function enrichContext(array $context): array
    {
        $context['ip'] = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $context['uri'] = $_SERVER['REQUEST_URI'] ?? 'unknown';
        $context['method'] = $_SERVER['REQUEST_METHOD'] ?? 'unknown';
        return $context;
    }
}