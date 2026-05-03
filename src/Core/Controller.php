<?php

namespace RoadMap\Core;

use RoadMap\Core\Exceptions\CriticallException;

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

        $viewPath = __DIR__ . '/../../templates/pages/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new CriticallException("Файл  {$view} не найден");
        }

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
    protected function getRequestParams(): array
    {
        return $this->router->getRequestParams();
    }
    protected function getMethod(): string
    {
        return $this->router->getMethod();
    }
}
