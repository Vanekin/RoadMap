<?php

namespace RoadMap\Core\Exceptions;

use Exception;

class PageNotFoundException extends Exception {
    protected $code = 404;

    public function __construct($message = "Страница не найдена") {
        parent::__construct($message, $this->code);
    }
}