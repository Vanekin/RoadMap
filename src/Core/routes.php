<?php

use RoadMap\Controllers\HomeController;
use RoadMap\Controllers\IncidentController;
use RoadMap\Controllers\AdminController;

return [
    '/' => [HomeController::class, 'index'],

    '/incidents' => [IncidentController::class, 'index'],
    '/incidents/create' => [IncidentController::class, 'create'],
    '/incidents/store' => [IncidentController::class, 'store'],

    '/admin' => [AdminController::class, 'index'],
];