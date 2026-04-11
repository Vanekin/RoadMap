<?php
namespace RoadMap\Core\Exceptions;
use Exception;
class ConfigException extends Exception {
    protected $code = 500;
    public function __construct(
        string $message = "Ошибка конфигурации приложения",
        int $code = 500,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    public function getUserFriendlyMessage(): string
    {
        return "Ошибка загрузки конфигурации приложения. "
            . "Пожалуйста, обратитесь к администратору.";
    }
}