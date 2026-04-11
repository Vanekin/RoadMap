<?php

namespace RoadMap\Controllers;
use RoadMap\Core\Controller;

class HomeController extends Controller {
    public function index(): void {
        $this->render('home', [
            'pageTitle' => 'Добро пожаловать'
        ]);
    }

}