<?php


namespace RoadMap;

class Router
{
    private array $routes;
    private string $method;
    private array $urlParams = [];
    private array $requestParams = [];
    private array $files;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->files = $_FILES;
        $this->extractRequestParams();
    }

    private function extractRequestParams(): void
    {
        if ($this->method === 'GET') {
            $this->requestParams = $_GET;
            return;
        }

        if ($this->method === 'POST' && empty($_SERVER['CONTENT_TYPE'])) {
            $this->requestParams = $_POST;
            return;
        }
    }

    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function dispatch(string $url): void {
        $fullPath = __DIR__ . '/../../public' . $url;

        if (file_exists($fullPath) && is_file($fullPath)) {
            $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'svg' => 'image/svg+xml',
                'ico' => 'image/x-icon',
            ];

            $mime = $mimeTypes[$ext] ?? 'application/octet-stream';
            header('Content-Type: ' . $mime);
            readfile($fullPath);
            exit;
        }
        $url = '/' . ltrim($url, '/');

        $matched = false;

        foreach ($this->routes as $routePattern => $handler) {
            $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)(?::([^}]+))?\}/', function ($matches) {
                $paramName = $matches[1];
                $regex = $matches[2] ?? '[^/]+';
                return '(?P<' . $paramName . '>' . $regex . ')';
            }, $routePattern);

            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $url, $matches)) {
                // Извлекаем параметры из URL
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $this->urlParams[$key] = $value;
                    }
                }

                $matched = true;

                if (is_array($handler) && count($handler) === 2) {
                    $controllerClass = $handler[0];
                    $method = $handler[1];
                    if (!class_exists($controllerClass)) {
                        $this->sendError(500, "Controller {$controllerClass} not found");
                        return;
                    }
                    $controller = new $controllerClass($this);
                    if (!method_exists($controller, $method)) {
                        $this->sendError(500, "Method {$method} not found in {$controllerClass}");
                        return;
                    }
                    $controller->$method();
                    return;
                }
                if (is_string($handler) && class_exists($handler)) {
                    $controller = new $handler($this);
                    if (method_exists($controller, 'index')) {
                        $controller->index();
                        return;
                    }
                }

                $this->sendError(500, "Сервер не смог обработать запрос");
                return;
            }
        }
        if (!$matched) {
            $this->sendError(404, "Страница не найдена");
        }
    }

    private function sendError(int $code, string $message): void
    {
        http_response_code($code);
        echo "$message";
        exit;
    }
}