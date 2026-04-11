<?php

namespace RoadMap\Controllers;

use RoadMap\Core\Controller;

class IncidentController extends Controller
{
    public function create(): void
    {
        $this->render('incidentsCreate', [
            'pageTitle' => 'Добавить происшествие'
        ]);
    }
    public function store(): void
    {
        $method = $this->getMethod();
        if ($method !== 'POST') {
            $this->redirect('/incidents/create');
            return;
        }

        $title = $this->getRequestParams()['title'];
        $description = $this->getRequestParams()['description'];

        $this->render('incidentsStore', [
            'pageTitle' => 'Происшествие добавлено',
            'old' => ['title' => $title, 'description' => $description]
        ]);
    }
}