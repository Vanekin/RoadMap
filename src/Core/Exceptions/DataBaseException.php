<?php

namespace RoadMap\Core\Exceptions;

use Exception;

class DataBaseException extends Exception
{
    protected $code = 500;
    public function __construct(
        string $message = "Ошибка базы данных",
        int $code = 500,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    public function getUserFriendlyMessage(): string
    {
        return "Произошла ошибка при работе с базой данных. Пожалуйста, попробуйте позже.";
    }
}
