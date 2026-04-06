<?php

use RoadMap\Controllers\HomeController;
use RoadMap\Controllers\IncidentController;
use RoadMap\Controllers\AdminController;

return [
    '/' => [HomeController::class, 'index'],

    '/incidents' => [IncidentController::class, 'index'],

    '/admin' => [AdminController::class, 'index'],
];