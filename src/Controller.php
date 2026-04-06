<?php

namespace RoadMap;

abstract class Controller
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {

        extract($data);

        $viewPath = __DIR__ . '/../templates/pages/' . $view . '.php';

        if (!file_exists($viewPath)) {
            $this->renderError(500, "Файл  {$view} не найден");
            return;
        }

        // Буферизация содержимого представления
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Путь к лэйауту
        $layoutPath = __DIR__ . '/../../templates/layouts/' . $layout . '.php';

        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            // Если лэйаут не найден, просто выводим содержимое
            echo $content;
        }
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }


    protected function renderError(int $code, string $message = ''): void {
        http_response_code($code);
        echo "<h1>Error {$code}</h1>";
        echo "<p>{$message}</p>";
        exit;
    }

    protected function getRequestParams(): array
    {
        return $this->router->getRequestParams();
    }


    protected function getFiles(): array
    {
        return $this->router->getFiles();
    }

    protected function getMethod(): string
    {
        return $this->router->getMethod();
    }
}