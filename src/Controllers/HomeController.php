<?php

namespace RoadMap\Controllers;

use RoadMap\Core\Controller;
use RoadMap\Core\Attributes\Route;

class HomeController extends Controller
{
    #[Route('/', method: 'GET')]
    public function index(): void
    {
        $this->render('home', [
            'pageTitle' => 'RoadMap - Карта дорожных происшествий'
        ]);
    }
}
