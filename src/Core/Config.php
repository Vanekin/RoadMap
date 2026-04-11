<?php

namespace RoadMap\Core;

use RoadMap\Core\Exceptions\ConfigException;
use RoadMap\Core\Exceptions\EnvFileNotFoundException;
use Dotenv\Dotenv;

class Config
{
    private static ?Config $instance = null;
    private array $config = [];
    private string $envPath;

    private array $requiredParams = [
        'APP_NAME',
        'APP_ENV',
        'APP_DEBUG',
        'DB_HOST',
        'DB_NAME',
        'DB_USER',
        'LOG_PATH',
        'LOG_LEVEL'
    ];

    private function __construct()
    {
        $this->envPath = __DIR__ . '/../..';
        $this->loadEnvFile();
        $this->loadConfig();
        $this->validateRequiredParams();
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadEnvFile(): void
    {
        if (!file_exists($this->envPath . '/.env')) {
            throw new EnvFileNotFoundException(
                "Файл .env не найден: {$this->envPath}/.env"
            );

        }
        $dotenv = Dotenv::createImmutable($this->envPath);
        $dotenv->load();
    }

    private function loadConfig(): void
    {
        $this->config = [
            'app' => [
                'name' => $_ENV['APP_NAME'] ?? 'RoadMap',
                'env' => $_ENV['APP_ENV'] ?? 'prod',
                'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ],
            'database' => [
                'host' => $_ENV['DB_HOST'] ?? 'localhost',
                'name' => $_ENV['DB_NAME'] ?? 'roadmap',
                'user' => $_ENV['DB_USER'] ?? 'postgres',
                'password' => $_ENV['DB_PASS'] ?? '',
            ],
            'logging' => [
                'path' => $_ENV['LOG_PATH'] ?? '/runtime/logs/app.log',
                'level' => $_ENV['LOG_LEVEL'] ?? 'info',
            ],
        ];
    }

    private function validateRequiredParams(): void
    {
        $missingParams = [];

        foreach ($this->requiredParams as $param) {
            $value = $_ENV[$param] ?? null;
            if ($value === null || $value === '') {
                $missingParams[] = $param;
            }
        }

        if (!empty($missingParams)) {
            throw new ConfigException(
                "Отсутствуют обязательные параметры: " . implode(', ', $missingParams)
            );
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $parts = explode('.', $key);

        if (count($parts) === 1) {
            return $_ENV[$key] ?? $default;
        }

        $section = $parts[0];
        $param = $parts[1];

        return $this->config[$section][$param] ?? $default;
    }

    public function isDebugMode(): bool
    {
        return (bool) $this->get('app.debug', false);
    }
}