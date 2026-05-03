<?php

namespace RoadMap\Core;

use PDO;
use PDOException;
use RoadMap\Core\Config;
use RoadMap\Core\Logger;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $connection = null;
    private Config $config;
    private Logger $logger;

    private function __construct()
    {
        $this->config = Config::getInstance();
        $this->logger = Logger::getInstance();
        $this->connect();
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        $driver = $this->config->get('DB_DRIVER', 'pgsql');
        $host = $this->config->get('DB_HOST', 'localhost');
        $port = $this->config->get('DB_PORT', '5432');
        $dbname = $this->config->get('DB_NAME', 'roadmap');
        $user = $this->config->get('DB_USER', 'postgres');
        $password = $this->config->get('DB_PASS', '');

        try {
            $dsn = "{$driver}:host={$host};port={$port};dbname={$dbname}";
            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $this->logger->info('Database connection established');
        } catch (PDOException $e) {
            $this->logger->error('Database connection failed: ' . $e->getMessage());

            if ($this->config->isDebugMode()) {
                die("Ошибка подключения к базе данных: " . $e->getMessage());
            }

            throw new DataBaseException("Не удалось подключиться к базе данных: " . $e->getMessage(), 500, $e);
        }
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            throw new DataBaseException("База данных не инициализирована");
        }
        return $this->connection;
    }
}
