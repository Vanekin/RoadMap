<?php

use RoadMap\Controllers\HomeController;
use RoadMap\Controllers\IncidentController;
use RoadMap\Controllers\AdminController;
use RoadMap\Controllers\UserController;

return [
    '/' => [HomeController::class, 'index'],

    '/incidents' => [IncidentController::class, 'index'],
    '/incidents/create' => [IncidentController::class, 'create'],
    '/incidents/store' => [IncidentController::class, 'store'],


    '/admin' => [AdminController::class, 'index'],

    '/register' => [UserController::class, 'showRegisterForm'],
    '/register/store' => [UserController::class, 'register'],
    '/login' => [UserController::class, 'showLoginForm'],
    '/login/store' => [UserController::class, 'login'],
    '/logout' => [UserController::class, 'logout'],
    '/profile' => [UserController::class, 'profile'],
];