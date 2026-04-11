<?php

require_once __DIR__ . '/../vendor/autoload.php';


use RoadMap\Core\Router;
use RoadMap\Core\Logger;
use RoadMap\Core\Config;
use RoadMap\Core\Exceptions\EnvFileNotFoundException;
use RoadMap\Core\Exceptions\ConfigException;

set_exception_handler(function (Throwable $e) {
    $code = $e->getCode();
    http_response_code($code);
    try {
        $logger = Logger::getInstance();
        $logger->critical($e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'code' => $code,
            'exception_type' => get_class($e)
        ]);
    } catch (Throwable $logError) {
        echo "Ошибка создания логов";
    }
    $errorPage = __DIR__ . '/../templates/pages/errorPage.php';
    if (file_exists($errorPage)) {
        $message = "Произошла ошибка. Пожалуйста, попробуйте позже.";
        require $errorPage;
    } else {
        echo "<h1>Ошибка{$code}</h1>";
        echo "<p>Произошла ошибка. Пожалуйста, попробуйте позже.</p>";
    }
    exit;
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

try {
    $config = Config::getInstance();
    if ($config->isDebugMode()) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        Logger::getInstance()->info('Режим DEBUG');
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
        Logger::getInstance()->info('Режим PRODUCTION');
    }

} catch (EnvFileNotFoundException $e) {
    Logger::getInstance()->critical("Файл конфигурации не найден");
    throw $e;

} catch (ConfigException $e) {
    Logger::getInstance()->error("Ошибка конфигурации приложения");
    throw $e;
}



$routes = require_once __DIR__ . '/../src/Core/routes.php';

$requestUri = $_SERVER['REQUEST_URI'];
$url = parse_url($requestUri, PHP_URL_PATH);
$url = trim($url, '/');
if (empty($url)) {
    $url = '/';
}

$router = new Router($routes);
$router->dispatch($url);