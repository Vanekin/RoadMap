<?php


namespace RoadMap\Core;
use RoadMap\Core\Exceptions\CriticallException;
use RoadMap\Core\Exceptions\PageNotFoundException;
use RoadMap\Core\Attributes\Route;

class Router
{
    private array $routes;
    private string $method;
    private array $urlParams = [];
    private array $requestParams = [];
    private array $files;

    public function __construct(array $controllers)
    {

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->files = $_FILES;
        $this->extractRequestParams();
        $this->register($controllers);
    }

    public function register(array $controllers): void
    {
        foreach ($controllers as $controllerClass) {
            $reflectionClass = new \ReflectionClass($controllerClass);

            foreach ($reflectionClass->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    /** @var Route $route */
                    $route = $attribute->newInstance();

                    $handler = [$controllerClass, $method->getName()];
                    $path = $route->path;
                    $httpMethods = (array) $route->method;

                    foreach ($httpMethods as $httpMethod) {
                        $this->routes[strtoupper($httpMethod)][$path] = $handler;
                    }
                }
            }
        }
    }

    private function extractRequestParams(): void
    {
        if ($this->method === 'GET') {
            $this->requestParams = $_GET;
            return;
        }

        if ($this->method === 'POST') {
            $this->requestParams = $_POST;
            return;
        }
    }

    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function dispatch(string $url): void
    {
        // Статические файлы
        $fullPath = __DIR__ . '/../../public' . $url;
        if (file_exists($fullPath) && is_file($fullPath)) {
            $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
            $mimeTypes = [
                'ico' => 'image/x-icon',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'svg' => 'image/svg+xml',
            ];

            $mime = $mimeTypes[$ext] ?? 'application/octet-stream';
            header('Content-Type: ' . $mime);
            readfile($fullPath);
            exit;
        }

        $url = '/' . ltrim($url, '/');

        // Получаем маршруты для текущего HTTP метода
        $routesByMethod = $this->routes[$this->method] ?? [];

        foreach ($routesByMethod as $routePattern => $handler) {
            $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)(?::([^}]+))?\}/', function ($matches) {
                $paramName = $matches[1];
                $regex = $matches[2] ?? '[^/]+';
                return '(?P<' . $paramName . '>' . $regex . ')';
            }, $routePattern);

            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $this->urlParams[$key] = $value;
                    }
                }

                if (is_array($handler) && count($handler) === 2) {
                    [$controllerClass, $method] = $handler;

                    if (!class_exists($controllerClass)) {
                        throw new CriticalException("Controller {$controllerClass} not found");
                    }

                    $controller = new $controllerClass($this);

                    if (!method_exists($controller, $method)) {
                        throw new CriticalException("Method {$method} not found");
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

                throw new CriticalException("Сервер не смог обработать запрос");
            }
        }

        throw new PageNotFoundException();
    }
}
