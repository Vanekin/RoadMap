<?php

namespace RoadMap\Core\Exceptions;
use Exception;
class EnvFileNotFoundException extends Exception {
    protected $code = 500;

    public function __construct(
        string $message = "Файл конфигурации не найден",
        int $code = 500,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getUserFriendlyMessage(): string
    {
        return "Не удалось загрузить конфигурацию приложения. "
            . "Пожалуйста, убедитесь, что файл конфигурации существует и доступен для чтения.";
    }

}